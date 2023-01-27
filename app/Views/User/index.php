<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="row justify-content-center">
    <div class="col-lg-10">
<div class="card">
  <div class="card-header">
    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sn" id="btnNew">
  <i class="fas fa-plus"></i>
</button>
  </div>
  <div class="card-body">
    <table class="table table-hover datatable text-center">
        <thead>
            <th style="width: 40px;">#</th>
            <th>Nama</th>
            <th>Level</th>
            <th></th>
        </thead>
        <tbody>
        <?php $no = 1; ?>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= ucwords($user->nama); ?></td>
                        <td><?= $user->role; ?></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
</div>

<div id="viewmodal" style="display: none;"></div>
<?= $this->endsection(); ?>

<?= $this->section('javascript'); ?>

<script>

$(document).ready(() => {
  $('#btnNew').click(() => {
    $.ajax({
      url:'users/newUser',
      dataType: 'json',
      beforesend: function() {
        $('#btnNew').attr('disabled', 'disabled');
      },
      success: function(response) {
        $('#btnNew').removeAttr('disabled');
        if (response.error) {
          if (response.error.logout) {
            window.location.href = response.error.logout
          }
        } else {
          $('#viewmodal').html(response.data).show();
          $('#addModal').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, throwError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError)
      }
    });
  })
})

</script>

<?= $this->endsection(); ?>