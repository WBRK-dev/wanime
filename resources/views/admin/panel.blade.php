@extends("layout.root")

@section("body")
    
    <div class="d-grid p-2 gap-2" style="grid-template-columns: repeat(auto-fill, minmax(500px, 1fr))">
        <div class="ratio ratio-16x9 w-100">
            <canvas id="days" ></canvas>
        </div>

        <div class="ratio ratio-16x9 w-100">
            <canvas id="hitperroute" ></canvas>
        </div>

        <div class="ratio ratio-16x9 w-100">
            <canvas id="authhitsperday" ></canvas>
        </div>

        <div class="ratio ratio-16x9 w-100">
            <canvas id="uniquehitsperday" ></canvas>
        </div>

        <div class="ratio ratio-16x9 w-100">
            <canvas id="hitsperhour" ></canvas>
        </div>
    </div>

@endsection

@section("head")
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>

        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 
              'Friday', 'Saterday'];

        function loadCharts() {

            let data = {!! $week !!};

            for (let i = 0; i < data.length; i++) {
                data[i].day = days[(new Date(data[i].day)).getDay()];
            }
    
            new Chart(
                document.getElementById('days'),
                {
                    type: 'line',
                    data: {
                        labels: data.map(row => row.day),
                        datasets: [{
                            label: 'Hits by Day',
                            data: data.map(row => row.count),
                            tension: 0.2
                        }]
                    }
                }
            );

            // Bar chart - Hits per route in a month
            data = {!! $hitperroute !!};
            let newData = [];
            let dataKeys = Object.keys(data);

            for (let i = 0; i < dataKeys.length; i++) {
                newData.push({
                    route: dataKeys[i],
                    count: data[dataKeys[i]]
                })
            }
    
            new Chart(
                document.getElementById('hitperroute'),
                {
                    type: 'bar',
                    data: {
                        labels: newData.map(row => row.route),
                        datasets: [{
                            label: 'Hits per Route',
                            data: newData.map(row => row.count),
                            tension: 0.2
                        }]
                    }
                }
            );

            // Stacked chart - Auth and non Auth per day in a week.
            data = {!! $weekAuth !!};
            
            for (let i = 0; i < data.length; i++) {
                data[i].day = days[(new Date(data[i].day)).getDay()];
            }
    
            new Chart(
                document.getElementById('authhitsperday'),
                {
                    type: 'bar',
                    data: {
                        labels: data.map(row => row.day),
                        datasets: [{
                            label: 'Authorized Hits',
                            data: data.map(row => row.auth),
                            tension: 0.2
                        },{
                            label: 'Non authorized Hits',
                            data: data.map(row => row.nonauth),
                            tension: 0.2
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                stacked: true,
                            },
                            y: {
                                stacked: true
                            }
                        }
                    }
                }
            );

            // Line chart - Unique hits per day (7 days)
            data = {!! $uniqueHits !!};

            for (let i = 0; i < data.length; i++) {
                data[i].day = days[(new Date(data[i].day)).getDay()];
            }
    
            new Chart(
                document.getElementById('uniquehitsperday'),
                {
                    type: 'line',
                    data: {
                        labels: data.map(row => row.day),
                        datasets: [{
                            label: 'Unique Hits',
                            data: data.map(row => row.count),
                            tension: 0.2
                        }]
                    }
                }
            );

            // Bar chart - Hits per hour (24 hours)
            data = {!! $hitsperhour !!};
    
            new Chart(
                document.getElementById('hitsperhour'),
                {
                    type: 'bar',
                    data: {
                        labels: data.map(row => row.hour),
                        datasets: [{
                            label: 'Hits per Hour',
                            data: data.map(row => row.count),
                            tension: 0.2022007

                        }]
                    }
                }
            );

        }

        window.onload = loadCharts;

    </script>

@endsection