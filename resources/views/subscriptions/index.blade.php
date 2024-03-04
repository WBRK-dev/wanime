@extends("layout.root")

@section("body")
    
<div class="d-flex justify-content-center p-2">

    <div class="c-table">

        <div class="c-row c-header">

            <div class="c-cell c-fixed-300"></div>
            <div class="c-cell c-fixed-150"><p class="m-0 fs-4">Free</p></div>
            <div class="c-cell c-fixed-150"><p class="m-0 fs-4">Plus</p></div>
            <div class="c-cell c-fixed-150"><p class="m-0 fs-4">Premium</p></div>

        </div>

        <div class="c-row">

            <div class="c-cell c-fixed-300 c-no-center">Amount of episode requests a day</div>
            <div class="c-cell c-fixed-150">Unlimited</div>
            <div class="c-cell c-fixed-150">Unlimited</div>
            <div class="c-cell c-fixed-150">Unlimited</div>

        </div>

        <div class="c-row">

            <div class="c-cell c-fixed-300 c-no-center ">Main provider backup <button style="all: unset;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="When the main provider is down you can use a different provider."><i class="fi fi-sr-info ms-1 text-body-secondary"></i></button></div>
            <div class="c-cell c-fixed-150"><i class="fi fi-sr-cross text-danger"></i></div>
            <div class="c-cell c-fixed-150"><i class="fi fi-sr-check text-success"></i></div>
            <div class="c-cell c-fixed-150"><i class="fi fi-sr-check text-success"></i></div>

        </div>

        <div class="c-row">

            <div class="c-cell c-fixed-300 c-no-center">Max amount of watchlist entries</div>
            <div class="c-cell c-fixed-150">200</div>
            <div class="c-cell c-fixed-150">500</div>
            <div class="c-cell c-fixed-150">Unlimited</div>

        </div>

        <div class="c-row">

            <div class="c-cell c-fixed-300 c-no-center">Outside Europe</div>
            <div class="c-cell c-fixed-150"><p class="m-0 fs-4">Free</p></div>
            <div class="c-cell c-fixed-150"><p class="m-0 fs-4">$2.50</p><p class="m-0">/year</p></div>
            <div class="c-cell c-fixed-150"><p class="m-0 fs-4">$5.00</p><p class="m-0">/year</p></div>

        </div>

        <div class="c-row">

            <div class="c-cell c-fixed-300 c-no-center">Inside Europe</div>
            <div class="c-cell c-fixed-150"><p class="m-0 fs-4">Free</p></div>
            <div class="c-cell c-fixed-150"><p class="m-0 fs-4">€2,50</p><p class="m-0">/year</p></div>
            <div class="c-cell c-fixed-150"><p class="m-0 fs-4">€5,00</p><p class="m-0">/year</p></div>

        </div>

        <div class="c-row">

            <div class="c-cell c-fixed-300 c-no-center"></div>
            <div class="c-cell c-fixed-150"></div>
            <div class="c-cell c-fixed-150"><button class="btn btn-primary">Buy</button></div>
            <div class="c-cell c-fixed-150"><button class="btn btn-primary">Buy</button></div>

        </div>

    </div>


</div>

@endsection

@section("head")
    
    <style>

        .c-table {
            border: 1px solid var(--bs-border-color);
            position: relative;
            border-radius: 10px;
            overflow-y: hidden;
        }

        .c-table .c-row {
            display: flex;
        }
        .c-table .c-row:not(:last-of-type) {border-bottom: 1px solid var(--bs-border-color);}
        .c-table .c-row.c-header {
            position: sticky;
            top: 0; left: 0;

            background-color: var(--bs-body-bg);
        }

        .c-table .c-row .c-cell {
            display: flex;
            padding: .5rem 1rem;
            min-height: 50px;

            box-sizing: border-box;
            flex-shrink: 0;

            justify-content: center;
            align-items: center;
        }
        .c-table .c-row .c-cell:not(:last-of-type) {border-right: 1px solid var(--bs-border-color);}
        .c-table .c-row .c-cell.c-fixed-300 {width: 300px;}
        .c-table .c-row .c-cell.c-fixed-150 {width: 150px;}
        .c-table .c-row .c-cell.c-no-center {justify-content: start;}

    </style>
    <script>
        window.onload = () => {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        }
    </script>

@endsection