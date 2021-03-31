<div class="modal fade" id="addFilmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Film</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
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
            <button type="submit" id="send" hidden></button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="document.getElementById('send').click()">Add Film</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteFilm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h3>Are you sure?</h3>
        <p>Want to delete <span id="FilmDeleteTitle"></span>?</p>
        <div class="text-right">
            <button type="button" onclick="cancelDeleteFilm()" class="btn btn-secondary ml-3">
                Cancel
            </button>
            <button type="button" onclick="sureDeleteFilm()" class="btn btn-danger">
                Sure
            </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const sureDeleteFilm = () => {
    $.ajax({
            type:'DELETE',
            dataType: 'json',
            url: "<?= base_url("/api/film?id=") ?>" + 
            $("#deleteFilm").data('id'),
            success: (data) => {
                $("#deleteFilm").data('id', '');
                $("#FilmDeleteTitle").html('');
                $("#deleteFilm").modal('hide');
                loadData();
            }
        })
}
const cancelDeleteFilm = () => {
    $("#deleteFilm").data('id', '');
    $("#FilmDeleteTitle").html('');
    $("#deleteFilm").modal('hide');
}
$(document).ready(() => {
    $("#loadAjax").hide();
    $("#addFilm").submit((e) => {
        $("#loadAjax").show()
        e.preventDefault();
        let arrOfData = {
            title: $('#inputTitle').val(),
            release: $('#inputYear').val(),
            description: $('#inputDesc').val(),
            rental_rate: $('#inputRental').val()
        };
        $.ajax({
            type:'POST',
            dataType: 'json',
            data: arrOfData,
            url: "<?= base_url("/api/film") ?>",
            success: (data) => {
                $('#inputTitle').val("");
                $('#inputYear').val("");
                $('#inputDesc').val("");
                $('#inputRental').val("");
                $("#addFilmModal").modal('hide');
                loadData();
            }
        })
        return false;
    })
})

</script>