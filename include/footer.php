<footer class="main-footer print-hilang">
    <strong>Copyright &copy; <?= date("Y"); ?> <?= $judul; ?>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Pro Version</b> 5.7.1
    </div>
  </footer>
  <div class="modal fade" id="logout">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="" method="POST">
        <div class="modal-body">
          <p style="font-weight: bold;">Ingin logout dari halaman?</p>
          <div id="data-hapus"></div>
          <div class="text-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <a href="<?= $link; ?>/logout" class="btn btn-danger">Logout</a>
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->