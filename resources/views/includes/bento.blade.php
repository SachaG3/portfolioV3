<div id="modal"
     class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-filter backdrop-blur-sm hidden"
     onclick="closeModal(event)">
    <div class="p-6 rounded-lg shadow-lg w-11/12 max-w-7xl" onclick="event.stopPropagation()">
        <div id="modal-content" class="grid grid-cols-10 gap-4">
            <!-- Modal content will be dynamically populated here -->
        </div>
    </div>
</div>

<script>
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
                    <div class="card shadow-lg bg-base-200 col-span-9">
                        <div class="card-body">
                            <h2 class="card-title">${data.title}</h2>
                            <p>${data.description}</p>
                        </div>
                    </div>

                    <!-- Card 2: GitHub and Website Links -->
                    <div class="card shadow-lg bg-base-200 col-span-1">
                        <div class="card-body flex items-center justify-center">
                            <div class="mt-4">
                                <a tabindex="0" href="${data.lien}" target="_blank"
                                   class="tooltip text-base-content" data-tip="${data.title}"
                                   aria-label="Profil GitHub de Sacha Guignard">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="lucide lucide-panel-top">
                                        <rect width="18" height="18" x="3" y="3" rx="2"/>
                                        <path d="M3 9h18"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Technology Used -->
                    <div class="card shadow-lg bg-base-200 col-span-3 row-span-2">
                        <div class="card-body">
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                ${data.technologies.map(tech => `
                                    <div class="flex justify-center items-center tooltip" data-tip="${tech.name}"
                                         aria-label="${tech.name}">
                                       ${tech.icon}
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Project.php Image -->
                    <div class="card shadow-lg bg-base-200 col-span-5 row-span-2">
                        <div class="card-body p-0">
                            <img src="${data.image}" width="100px" alt="Project Thumbnail"
                                 class="rounded-lg w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Card 5: Project.php Participants -->
                    <div class="card shadow-lg bg-base-200 col-span-2 row-span-2">
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
                    <div class="card shadow-lg bg-base-200 col-span-7">
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
                    <div class="card shadow-lg bg-base-200 col-span-3">
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
            const modal = document.getElementById('modal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        });
    }

    function closeModal(event) {
        const modal = document.getElementById('modal');
        if (modal) {
            const modalContent = document.querySelector('#modal > div');
            if (event && modalContent && !modalContent.contains(event.target)) {
                modal.classList.add('hidden');
            } else if (!event) {
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
</script>

