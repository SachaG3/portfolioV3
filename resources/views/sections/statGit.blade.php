<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .modal-box-custom {
        border-radius: 1rem;
        backdrop-filter: blur(8px);
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    #stats-modal .modal-box {
        width: 90%;
        max-width: 900px;
        height: 500px;
        position: relative;
    }

    #statsChart {
        width: 100%;
        height: 100%;
    }
</style>

<div id="stats-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="modal-box modal-box-custom relative p-6 bg-base-200 overflow-auto">
        <button class="btn btn-sm btn-circle absolute right-4 top-4 hidden" onclick="closeStatsModal()">✕</button>
        <h1 class="text-3xl font-bold mb-4">Statistiques GitHub pour SachaG3</h1>
        <canvas id="statsChart"></canvas>
    </div>
</div>

<script>
    let rawLabels, rawCommits, rawRepos;

    function movingAverage(data, windowSize) {
        var result = [];
        for (var i = 0; i < data.length; i++) {
            var start = Math.max(0, i - Math.floor(windowSize / 2));
            var end = Math.min(data.length, i + Math.floor(windowSize / 2) + 1);
            var sum = 0;
            for (var j = start; j < end; j++) {
                sum += data[j];
            }
            result.push(Math.ceil(sum / (end - start)));
        }
        return result;
    }

    function formatDate(d) {
        var year = d.getFullYear();
        var month = ('0' + (d.getMonth() + 1)).slice(-2);
        var day = ('0' + d.getDate()).slice(-2);
        return year + '-' + month + '-' + day;
    }

    function computeWindowSize() {
        var modalBox = document.querySelector('#stats-modal .modal-box');
        var width = modalBox.offsetWidth;
        var calculatedWindowSize = Math.floor(width / 300);
        var windowSize = Math.max(2, Math.min(calculatedWindowSize, 10));
        return windowSize;
    }


    function downsampleArray(data, maxPoints) {
        if (data.length <= maxPoints) return data;
        var sampled = [];
        var step = data.length / maxPoints;
        for (var i = 0; i < maxPoints; i++) {
            sampled.push(data[Math.floor(i * step)]);
        }
        return sampled;
    }

    function downsampleLabels(labels, maxPoints) {
        if (labels.length <= maxPoints) return labels;
        var sampled = [];
        var step = labels.length / maxPoints;
        for (var i = 0; i < maxPoints; i++) {
            sampled.push(labels[Math.floor(i * step)]);
        }
        return sampled;
    }

    var statsChart;

    function drawChart() {
        var modalBox = document.querySelector('#stats-modal .modal-box');
        var width = modalBox.offsetWidth;
        var windowSize = computeWindowSize();
        var smoothCommits = movingAverage(rawCommits, windowSize);
        var smoothRepos = movingAverage(rawRepos, windowSize);

        var maxPoints = Math.max(5, Math.floor(width / 80));
        var sampledLabels = downsampleLabels(rawLabels, maxPoints);
        var sampledCommits = downsampleArray(smoothCommits, maxPoints);
        var sampledRepos = downsampleArray(smoothRepos, maxPoints);

        var todayLabel = formatDate(new Date());
        var desiredLastDate = todayLabel;
        if (rawLabels.indexOf(todayLabel) === -1) {
            var yesterday = new Date();
            yesterday.setDate(yesterday.getDate() - 1);
            desiredLastDate = formatDate(yesterday);
        }
        var idx = rawLabels.indexOf(desiredLastDate);
        if (idx !== -1) {
            sampledLabels[sampledLabels.length - 1] = rawLabels[idx];
            sampledCommits[sampledCommits.length - 1] = rawCommits[idx];
            sampledRepos[sampledRepos.length - 1] = rawRepos[idx];
        }

        var ctx = document.getElementById('statsChart').getContext('2d');
        if (statsChart) {
            statsChart.destroy();
        }
        statsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: sampledLabels,
                datasets: [
                    {
                        label: 'Nombre Commits',
                        data: sampledCommits,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Nombre de Repository',
                        data: sampledRepos,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {display: true, text: 'Date'}
                    },
                    y: {
                        title: {display: true, text: 'Nombre'},
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function openStatsModal() {
        var modal = document.getElementById('stats-modal');
        modal.classList.remove('hidden');
        var modalBox = modal.querySelector('.modal-box');
        modalBox.classList.remove('fade-in');
        void modalBox.offsetWidth;
        modalBox.classList.add('fade-in');

        // Récupération des statistiques via fetch au moment de l'ouverture du modal
        fetch('/stats-data')
            .then(response => response.json())
            .then(data => {
                rawLabels = data.labels;
                rawCommits = data.commits;
                rawRepos = data.repos;
                drawChart();
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des statistiques:', error);
            });
    }

    function closeStatsModal() {
        document.getElementById('stats-modal').classList.add('hidden');
    }

    document.getElementById('stats-modal').addEventListener('click', function (event) {
        if (event.target === this) closeStatsModal();
    });

    window.addEventListener('resize', function () {
        var modal = document.getElementById('stats-modal');
        if (!modal.classList.contains('hidden')) {
            drawChart();
        }
    });
</script>
