<div class="container my-5">
    <div>
        <div class="row my-3">
            <div class="col-md">
                <h3>List Films</h3>
            </div>
            <div class="col-md d-md-flex justify-content-end">
                <div>
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addFilmModal">+ Add Film</button>
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addCategoryModal">+ Add Category</button>
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addActorModal">+ Add Actor</button>
                </div>
            </div>
        </div>
        <table class="table" id="parentTable">
            <thead  class="table-dark">
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Title</th>
                    <th scope="col">Release Year</th>
                    <th scope="col">Description</th>
                    <th scope="col">Rental Rate</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="appendData">
            <!-- If ajax success, here will append all of data -->
            </tbody>
        </table>
    </div>
    <div class="loading" id="loadSpinner">
        <div class="spinner-border text-danger" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<script>
const loadData = () => {
    $("#appendData>tr").remove();
    let arrOfData = [];
    $.ajax({
            type:'GET',
            dataType: 'json',
            url: "<?= base_url("/api/film") ?>",
            success: (data) => {
                $("#loadSpinner").hide();
                $("#parentTable").show();
                arrOfData = data.data;
                arrOfData.map((el, i) => {
                    $('#appendData').append(`
                    <tr>
                        <th scope="row">${i + 1}</th>
                        <td>${el.title}</td>
                        <td>${el.release_year}</td>
                        <td>${el.description}</td>
                        <td>${el.rental_rate}</td>
                        <td>
                            <button type="button" onclick="toDetail(${el.id})" class="btn btn-primary">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button type="button" onclick="toUpdate(${el.id})" class="btn btn-light">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" onclick="toDelete(${el.id}, '${el.title}')" class="btn btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    `);
                })
            }
        })
}
$(document).ready(()=>{
    $("#parentTable").hide();
    $("#loadSpinner").show();
    loadData();
})
const toDetail = (id) => {
    window.location.href = "<?= base_url("app/detail?id=") ?>" + id;
}
const toUpdate = (id) => {
    window.location.href = "<?= base_url("app/update?id=") ?>" + id;
}
const toDelete = (id, title) => {
    $("#deleteFilm").data('id', id)
    $("#FilmDeleteTitle").html(`${title}`)
    $("#deleteFilm").modal('show')
}
</script>