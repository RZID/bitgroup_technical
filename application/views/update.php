<div class="container my-5">
    <h3>Update Film Details</h3>
    <div class="mt-4">
        <h4>Main Film Detail</h4>
        <form id="addFilm">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="inputTitle" placeholder="Title" required>
                <label for="inputTitle">Title</label>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="inputYear" min="1000" max="9999" placeholder="Release Year" required>
                        <label for="inputYear">Release Year</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="inputRental"  placeholder="Rental Rate" step="any" required>
                        <label for="inputRental">Rental Rate</label>
                    </div>
                </div>
            </div>
            <div class="form-floating">
                <textarea class="form-control" placeholder="Description" id="inputDesc" required></textarea>
                <label for="inputDesc">Description</label>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary" id="send">Save Main Film Detail</button>
            </div>
        </form>
        <hr>
        <h4>Categories</h4>
        <div class="container">
            <div class="row" id="cat"></div>
        </div>
        <hr>
        <h4>Actors</h4>
        <div class="container">
            <div class="row" id="act"></div>
        </div>
    </div>
</div>

<script>
    $("#addFilm").submit((e) => {
        e.preventDefault();
        let arrOfData = {
            title: $('#inputTitle').val(),
            release: $('#inputYear').val(),
            description: $('#inputDesc').val(),
            rental_rate: $('#inputRental').val()
        }
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data:arrOfData,
            url: "<?= base_url("/api/film_detail?id=$id") ?>",
            success: (data) => {
                location.reload();
            }
        })
        return false;
    })
    $(document).ready(() => {
        let arrOfData = []
        $.ajax({
            type:'GET',
            dataType: 'json',
            url: "<?= base_url("/api/film_detail?id=$id") ?>",
            success: (data) => {
                $("#inputTitle").val(data.data.detail.title)
                $("#inputYear").val(data.data.detail.release_year)
                $("#inputRental").val(data.data.detail.rental_rate)
                $("#inputDesc").val(data.data.detail.description)
            }
        })
        $.ajax({
            type: 'GET',
            dataType: 'jsonp',
            url:"<?= base_url("/api/categories") ?>",
            success:(data) => {
                data.map((el,i) => {
                $("#cat").append(`<div class="col form-check"><input class="form-check-input" type="checkbox" value="${el.id}" id="flexCheckDefault"><label class="form-check-label" for="flexCheckDefault">${el.name}</label></div>`)
            })
            }
        })
        $.ajax({
            type: 'GET',
            dataType: 'jsonp',
            url:"<?= base_url("/api/actors") ?>",
            success:(data) => {
                data.map((el,i) => {
                $("#act").append(`<div class="col form-check"><input class="form-check-input" type="checkbox" value="${el.id}" id="flexCheckDefault"><label class="form-check-label" for="flexCheckDefault">${el.name}</label></div>`)
            })
            }
        })
    })
</script>