$(document).ready(function () {
    $(".owl-carousel").owlCarousel({
        loop: true,
        nav: false,
        autoplay: true,
        autoplayTimeout: 9000,
        items: 1,
        center: true,
        margin: 60,
        dots: false,
        mergeFit: true,
        autoWidth: true,
        responsive: {
            0: {
                items: 1,
                center: true,
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    });
});

async function fetchModalData(projectId) {
    try {
        const response = await fetch(`/api/project/${projectId}`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        const modalContent = document.getElementById('modal-content');
        if (modalContent) {
            modalContent.innerHTML = `
                <!-- Card 1: Description -->
                <div class="card shadow-lg bg-base-200 lg:col-span-9 col-span-10 row-span-2">
                    <div class="card-body">
                        <h2 class="card-title">${data.title}</h2>
                        <p>${data.description}</p>
                    </div>
                </div>
                <div class="card shadow-lg bg-base-200 lg:col-span-10 col-span-10 row-span-2 lg:hidden block">
                    <div class="card-body p-0">
                        <img src="${data.image}" width="100px" alt="Project Thumbnail"
                             class="rounded-lg w-full h-full object-cover">
                    </div>
                </div>

                <!-- Card 2: GitHub and Website Links -->
                <div class="card shadow-lg bg-base-200 lg:col-span-1 lg:row-span-2 col-span-3 row-span-3">
                    <div class="card-body flex items-center justify-center">
                        <div class="mt-4">
                            <a tabindex="0" href="${data.lien}" target="_blank"
                               class="tooltip text-base-content" data-tip="${data.title}"
                               aria-label="Profil GitHub de Sacha Guignard">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="lucide lucide-panel-top hidden lg:block">
                                    <rect width="18" height="18" x="3" y="3" rx="2"/>
                                    <path d="M3 9h18"/>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="lucide lucide-panel-top lg:hidden block">
                                    <rect width="18" height="18" x="3" y="3" rx="2"/>
                                    <path d="M3 9h18"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Technology Used -->
                <div class="card shadow-lg bg-base-200 lg:col-span-3 lg:row-span-2 col-span-7 row-span-3">
                    <div class="card-body">
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            ${data.technologies.map(tech => `
                                <div class="flex justify-center items-center tooltip" data-tip="${tech.name}"
                                     aria-label="${tech.name}">
                                    <span class="block lg:hidden">${tech.icon.replace('<svg', '<svg width="40" height="40"')}</span>
                                    <span class="lg:block hidden">${tech.icon}</span>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>

                <!-- Card 4: Project.php Image -->
                <div class="card shadow-lg bg-base-200 lg:col-span-5 hidden lg:block">
                    <div class="card-body p-0">
                        <img src="${data.image}" width="100px" alt="Project Thumbnail"
                             class="rounded-lg w-full h-full object-cover">
                    </div>
                </div>

                <!-- Card 5: Project.php Participants -->
                <div class="card shadow-lg bg-base-200 lg:col-span-2 lg:row-span-2 col-span-10 hidden lg:block">
                    <div class="card-body">
                        <div class="mt-2">
                            ${data.participants.map(participant => `
                                <div class="flex items-center mb-2">
                                    <div class="avatar online">
                                        <div class="w-12 rounded-full">
                                            <img src="${participant.avatar}" alt="Participant Avatar">
                                        </div>
                                    </div>
                                    <p class="ml-2">${participant.name}</p>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>

                <!-- Card 6: Font and Colors -->
                <div class="card shadow-lg bg-base-200 lg:col-span-7 col-span-10 hidden lg:block">
                    <div class="card-body">
                        <div class="mt-2">
                            <div class="flex items-center mb-4">
                                <p class="font-roboto text-lg">Font : ${data.font}</p>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                ${data.colors.map(color => `
                                    <div class="flex flex-col items-center tooltip" data-tip="Cliquez pour copier"
                                         aria-label="Cliquez pour copier">
                                        <div class="w-12 h-12 rounded cursor-pointer" style="background-color: ${color.hex};"
                                             data-color="${color.hex}" onclick="copyColor(this)">
                                        </div>
                                        <p class="text-lg mt-2">${color.hex}</p>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 7: Gallery Button -->
                <div class="card shadow-lg bg-base-200 lg:col-span-3 col-span-10 hidden lg:block">
                    <div class="card-body">
                        <h2 class="card-title">Gallery</h2>
                        <button class="btn btn-primary mt-4">View Gallery</button>
                    </div>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error fetching modal data:', error);
    }
}

function openModal(projectId) {
    fetchModalData(projectId).then(() => {
        const body = document.body;
        body.style.overflow = 'hidden';
        const modal = document.getElementById('modal');
        if (modal) {
            modal.classList.remove('hidden');
        }
    });
}

function closeModal(event) {
    const modal = document.getElementById('modal');
    const body = document.body;
    if (modal) {
        const modalContent = document.querySelector('#modal > div');
        if (!event || (modalContent && !modalContent.contains(event.target))) {
            body.style.overflow = 'auto';
            modal.classList.add('hidden');
        }
    }
}

function copyColor(element) {
    const color = element.getAttribute('data-color');
    navigator.clipboard.writeText(color).then(() => {
        element.parentElement.setAttribute('data-tip', 'Couleur copiée !');
        setTimeout(() => {
            element.parentElement.setAttribute('data-tip', 'Cliquez pour copier');
        }, 2000);
    }).catch(err => {
        console.error('Failed to copy text: ', err);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    if (window.innerWidth < 1024) {
        const mobileHeadingContainer = document.getElementById('mobile-heading-container');
        if (mobileHeadingContainer) {
            const h1 = document.createElement('h1');
            h1.className = 'text-3xl lg:text-5xl dark:text-white font-bold mt-2 leading-tight text-center lg:text-left lg:ml-4';
            h1.setAttribute('itemprop', 'jobTitle');
            h1.textContent = 'Développeur backend';
            mobileHeadingContainer.appendChild(h1);
        }
        const desktopHeading = document.getElementById('desktop-heading');
        if (desktopHeading) {
            desktopHeading.remove();
        }
    }

    const menuButton = document.getElementById('menu-button');
    const dropdownMenu = document.getElementById('mobile-dropdown-menu');
    const menuLinks = document.querySelectorAll('.menu-link');

    if (menuButton && dropdownMenu) {
        menuButton.addEventListener('click', (event) => {
            event.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });

        menuLinks.forEach(link => {
            link.addEventListener('click', () => dropdownMenu.classList.add('hidden'));
        });

        document.addEventListener('click', () => {
            if (!dropdownMenu.classList.contains('hidden')) {
                dropdownMenu.classList.add('hidden');
            }
        });

        dropdownMenu.addEventListener('click', (event) => {
            event.stopPropagation();
        });
    }

    const accueilLink = document.querySelector('a[aria-label="Accueil"]');
    if (accueilLink) {
        accueilLink.addEventListener('click', (event) => {
            event.preventDefault();
            if (window.location.pathname !== '/') {
                window.location.href = '/';
            }
        });
    }

    const pdfModal = document.getElementById("pdfModal");
    const pdfFrame = document.getElementById("pdfFrame");
    if (pdfModal && pdfFrame) {
        pdfModal.addEventListener("click", (event) => {
            if (event.target === pdfModal) {
                closePDFModal();
            }
        });
    }
});

function remToPx(rem) {
    return rem * parseFloat(getComputedStyle(document.documentElement).fontSize);
}

const scrollToId = (id) => {
    const element = document.getElementById(id);
    if (element) {
        const yOffset = element.classList.contains('md:py-16') ? 0 : -remToPx(4);
        const targetScrollPosition = element.getBoundingClientRect().top + window.scrollY + yOffset;
        window.scrollTo({behavior: 'smooth', top: targetScrollPosition});
    }
};
window.scrollToId = scrollToId;


const modal = document.getElementById("pdfModal");


function openPDFModal() {
    const modal = document.getElementById("pdfModal");
    const pdfFrame = document.getElementById("pdfFrame");
    const body = document.body;
    body.style.overflow = "hidden";
    modal.classList.remove("hidden");
    pdfFrame.src = "cv.pdf";
}

function closePDFModal() {
    const modal = document.getElementById("pdfModal");
    const pdfFrame = document.getElementById("pdfFrame");
    const body = document.body;
    body.style.overflow = "auto";
    modal.classList.add("hidden");
    pdfFrame.src = "";
}

modal.addEventListener("click", function (event) {
    if (event.target === modal) {
        closePDFModal();
    }
});
