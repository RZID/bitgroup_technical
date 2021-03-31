<div>
    <div class="container py-5">
        <div class="row min-content">
            <div class="col-md-3 random-image"></div>
            <div class="col d-flex">
                <div class="align-self-center w-100">
                    <div class="row">
                        <div class="col">
                            <h3 id="titleAndReleaseField" class="m-0"></h3> 
                        </div>
                        <div class="col d-flex justify-content-end">
                            <h5 class="m-0"><i class="bi bi-star-fill"></i> <span id="rentalField"></span></h5>
                        </div>
                    </div>
                        <hr>
                        <p id="descField"></p>
                        <div class="border-bottom mb-2">
                            <h6>
                                <i class="bi bi-person"></i> Actors : <span id="fieldActor"></span>
                            </h6>
                        </div>
                            <h6>
                                <i class="bi bi-tags"></i> Categories : <span id="fieldCategories"></span>
                            </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(() => {
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: "<?= base_url("/api/film_detail?id=$id") ?>",
            success: (data) => {
                    $('#titleAndReleaseField').html(data.data.detail.title + ' (' + data.data.detail.release_year + ')')
                    $('#rentalField').html(data.data.detail.rental_rate)                
                    $('#descField').html(data.data.detail.description)
                    if(data.data.actors.length > 0){
                        if(i == data.data.actors.length - 1)
                            {
                                return el.name
                            }else
                            {
                                return el.name + ', '
                            }
                    }else{
                        $("#fieldActor").html('N/A')
                    }
                    if(data.data.categories.length > 0){
                        $("#fieldCategories").html(data.data.categories.map((el, i) => {
                            if(
                                i == data.data.categories.length - 1
                            ){
                                return el.name
                            }else{
                                return el.name + ', '
                            }
                        }))
                    }else{
                        $("#fieldCategories").html('N/A')
                    }
            }
        })
    })
</script>