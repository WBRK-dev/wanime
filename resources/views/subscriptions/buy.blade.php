@extends("layout.root")

@section("body")
    
    <div class="gridview h-100 p-2 gap-2">
        <div>

            <div class="mb-3">

                <h4>Currency</h4>

                <div class="d-flex flex-wrap gap-2">

                    <label for="currencyeuro" class="rounded p-2 bg-body-secondary d-flex align-items-center gap-1"><input type="radio" class="form-check-input m-0" name="currency" id="currencyeuro" @checked(Request::input("currency") === "euro" || Request::input("currency") === null)>Euro</label>
                    <label for="currencydollar" class="rounded p-2 bg-body-secondary d-flex align-items-center gap-1"><input type="radio" class="form-check-input m-0" name="currency" id="currencydollar" @checked(Request::input("currency") === "dollar")>Dollar</label>

                </div>

            </div>

            <div class="mb-3">

                <h4>Subscription</h4>

                <label class="rounded p-2 d-flex align-items-center bg-body-secondary gap-2 mb-2" for="subscriptionplus"><input type="radio" class="form-check-input m-0" name="subscription" id="subscriptionplus" @checked(Request::input("subscription") === "plus")><p class="m-0">Plus</p><p class="m-0 ms-auto">€ 2,50</p></label>
                <label class="rounded p-2 d-flex align-items-center bg-body-secondary gap-2" for="subscriptionpremium"><input type="radio" class="form-check-input m-0" name="subscription" id="subscriptionpremium" @checked(Request::input("subscription") === "premium" || Request::input("subscription") === null)><p class="m-0">Premium</p><p class="m-0 ms-auto">€ 5,00</p></label>
                <p class="m-0 text-body-secondary">All subscriptions have a duration of 365 days.</p>

            </div>

            <div class="mb-3">

                <h4>Payment Option</h4>

                <div class="d-flex flex-wrap gap-2">

                    <label for="paymentpaypal" class="rounded p-2 bg-body-secondary d-flex align-items-center gap-1"><input type="radio" class="form-check-input m-0" name="payment" id="paymentpaypal" checked>PayPal</label>
                    <label for="paymenting" class="rounded p-2 bg-body-secondary d-flex align-items-center gap-1"><input type="radio" class="form-check-input m-0" name="payment" id="paymenting">ING Payment Request <i class="fi fi-sr-info text-body-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Only available in the Netherlands and payable with every bank in the Netherlands. When this is selected it will automatically use the euro currency."></i></label>

                </div>

            </div>



        </div>
        <div class="bg-body-secondary rounded p-2 d-flex flex-column">

            <h4>Payment</h4>

            <div class="d-flex"><p class="m-0">Subscription:</p><p class="m-0 ms-auto">€ 5,00</p></div>
            <div class="d-flex"><p class="m-0">Extra costs:</p><p class="m-0 ms-auto">€ 0,20</p></div>

            <div class="d-flex mt-auto align-items-end"><p class="m-0">Total:</p><p class="m-0 ms-auto fs-4">€ 5,20</p></div>
            <button class="btn btn-primary">Buy</button>

        </div>
    </div>

@endsection

@section("head")
    
    <style>

        .gridview {
            display: grid;
            grid-template-columns: 1fr 300px;
        }

    </style>
    <script>
        window.onload = () => {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        }
    </script>

@endsection