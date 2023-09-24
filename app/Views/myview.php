<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-4">
                <form action="<?php echo base_url();?>insert-data" method="post">
                    <input type="text" class="form-control mb-3" name="product" id="product" placeholder="Nama Produk" autofocus>
                    <input type="text" class="form-control mb-3" name="category" id="category" placeholder="Kategori">
                    <input type="text" class="form-control mb-3" name="qty" id="qty" placeholder="Qty">
                    <input type="text" class="form-control mb-3" name="price" id="price" placeholder="Harga">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-8">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="data">
                            <?php foreach($rows as $row) :?>
                                <tr>
                                    <td><?php echo $row->product;?></td>
                                    <td><?php echo $row->category;?></td>
                                    <td><?php echo $row->qty;?></td>
                                    <td><?php echo $row->price;?></td>
                                    <td>
                                        <button class="btn btn-sm btn-danger float-end" onclick="showModalDelete('<?php echo $row->id;?>')">Hapus</button>
                                        <button class="btn btn-sm btn-light border float-end me-2" onclick="showModalEdit('<?php echo $row->id;?>')">Edit</button>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalEditLabel">Edit Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url();?>update" method="post" id="formEdit">
                        <input type="hidden" name="editId" id="editId">
                        <input type="text" class="form-control mb-3" name="newProduct" placeholder="Nama Produk" autofocus>
                        <input type="text" class="form-control mb-3" name="newCategory" placeholder="Kategori">
                        <input type="text" class="form-control mb-3" name="newQty" placeholder="Qty">
                        <input type="text" class="form-control mb-3" name="newPrice" placeholder="Harga">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalDeleteLabel">Hapus Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        Apakah Anda yakin akan menghapus data ini?
                    </div>
                    <div class="form">
                        <button class="btn btn-sm btn-light border float-end" data-bs-dismiss="modal">Tidak</button>
                        <form action="<?php echo base_url();?>delete" method="post" id="formDelete">
                            <input type="hidden" name="deleteId" id="deleteId">
                            <button type="submit" class="btn btn-sm btn-danger float-end me-2">Ya hapus</button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
    <script>
        let baseUrl = '<?php echo base_url();?>'
        let modalEdit
        let modalDelete

        const showModalEdit = (id) => {
            $.ajax(
                {
                    url: `${baseUrl}getdata/${id}`,
                    method: 'get',
                    dataType: 'json',
                    success: res => {
                        let row = res[0]

                        $('[name="editId"]').val(row.id)
                        $('[name="newProduct"]').val(row.product)
                        $('[name="newCategory"]').val(row.category)
                        $('[name="newQty"]').val(row.qty)
                        $('[name="newPrice"]').val(row.price)

                        let options = {
                            backdrop: true,
                            kerboard: true
                        }
                        modalEdit = new bootstrap.Modal('#modalEdit', options)
                        modalEdit.show()
                    }
                }
            )
            
        }

        const showModalDelete = (id) => {
            $('[name="deleteId"]').val(id)
            let options = {
                backdrop: true,
                kerboard: true
            }
            modalDelete = new bootstrap.Modal('#modalDelete', options)
            modalDelete.show()
        }

        const mapData = (data) => {
            let tr = ''
            data.map(row => {
                tr+=`<tr>
                        <td>${row['product']}</td>
                        <td>${row['category']}</td>
                        <td>${row['qty']}</td>
                        <td>${row['price']}</td>
                        <td>
                            <button class="btn btn-sm btn-danger float-end" onclick="showModalDelete('${row['id']}')">Hapus</button>
                            <button class="btn btn-sm btn-light border float-end me-2" onclick="showModalEdit('${row['id']}')">Edit</button>
                        </td>
                    </tr>`
            })
            $('tbody#data').html(tr)
        }

        $('#formDelete').ajaxForm(
            {
                success: res => {
                    let data = JSON.parse(res)
                    mapData(data)
                    modalDelete.hide()
                }
            }
        )
        $('#formEdit').ajaxForm(
            {
                success: res => {
                    let data = JSON.parse(res)
                    mapData(data)
                    modalEdit.hide()
                }
            }
        )
    </script>
</body>
</html>