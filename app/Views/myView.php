<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-3">
                <form action="<?php echo base_url();?>insert-data" method="post" id="formInsert">
                    <input type="text" name="product" placeholder="product" class="form-control mb-2">
                    <input type="text" name="category" placeholder="category" class="form-control mb-2">
                    <input type="text" name="qty" placeholder="qty" class="form-control mb-2">
                    <input type="text" name="price" placeholder="price" class="form-control mb-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-9">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="data">
                            <?php foreach($rows as $row): ?>
                                <tr>
                                    <td><?php echo $row->product;?></td>
                                    <td><?php echo $row->category;?></td>
                                    <td><?php echo $row->qty;?></td>
                                    <td><?php echo $row->price;?></td>
                                    <td>
                                        <button class="btn btn-sm btn-light border" onclick="showEditModal('<?php echo $row->id;?>')">Edit</button>
                                        <button class="btn btn-sm btn-danger" onclick="showDeleteModal('<?php echo $row->id;?>')">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        Apakah Anda yakin akan menghapus data ini?
                    </div>
                    <div>
                        <button class="btn btn-sm btn-light border float-end" data-bs-dismiss="modal">Tidak</button>
                        <form action="<?php echo base_url();?>delete-data" method="post" id="formDelete">
                            <input type="hidden" name="deleteId">
                            <button type="submit" class="btn btn-sm btn-danger float-end me-2">Ya hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url();?>edit-data" method="post" id="formEdit">
                        <input type="hidden" name="editId">
                        <input type="text" name="newProduct" placeholder="product" class="form-control mb-2">
                        <input type="text" name="newCategory" placeholder="category" class="form-control mb-2">
                        <input type="text" name="newQty" placeholder="qty" class="form-control mb-2">
                        <input type="text" name="newPrice" placeholder="price" class="form-control mb-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
    <script>
        let deleteModal
        let editModal
        let baseUrl = '<?php echo base_url();?>'
        const showDeleteModal = (id) => {
            $('[name="deleteId"]').val(id)
            let options = {
                backdrop: true
            }
            deleteModal = new bootstrap.Modal('#deleteModal',options)
            deleteModal.show()
        }
        const showEditModal = (id) => {
            $.ajax(
                {
                    url: `${baseUrl}getdata/${id}`,
                    dataType: 'json',
                    method: 'get',
                    success: res => {
                        let row = res[0]
                        $('[name="editId"]').val(id)
                        $('[name="newProduct"]').val(row['product'])
                        $('[name="newCategory"]').val(row['category'])
                        $('[name="newQty"]').val(row['qty'])
                        $('[name="newPrice"]').val(row['price'])

                        let options = {
                            backdrop: true
                        }
                        editModal = new bootstrap.Modal('#editModal', options)
                        editModal.show()
                    }
                }
            )
        }
        const mapData = (data) => {
            let tr = ''
            data.map( row => {
                tr+=`<tr>
                        <td>${row['product']}</td>
                        <td>${row['category']}</td>
                        <td>${row['qty']}</td>
                        <td>${row['price']}</td>
                        <td>
                            <button class="btn btn-sm btn-light border" onclick="showEditModal('${row['id']}')">Edit</button>
                            <button class="btn btn-sm btn-danger" onclick="showDeleteModal('${row['id']}')">Delete</button>
                        </td>
                    </tr>`
            })
            $('tbody#data').html(tr)
        }
        $('#formInsert').ajaxForm(
            {
                success: res => {
                    let data = JSON.parse(res)
                    mapData(data)
                }
            }
        )
        $('#formDelete').ajaxForm(
            {
                success: res => {
                    let data = JSON.parse(res)
                    mapData(data)
                    deleteModal.hide()
                }
            }
        )
        $('#formEdit').ajaxForm(
            {
                success: res => {
                    let data = JSON.parse(res)
                    mapData(data)
                    editModal.hide()
                }
            }
        )
    </script>
</body>
</html>
