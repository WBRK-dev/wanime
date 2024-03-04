<div class="modal fade" id="newyearmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Happy New Year!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Expect a free gift in the near future!🎆🎉
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
if (localStorage.getItem("newyearsmessage") !== "2024") {
    (new bootstrap.Modal('#newyearmodal')).show();
    localStorage.setItem("newyearsmessage", "2024");
}
</script>