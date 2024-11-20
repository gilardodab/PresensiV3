<form id="validate" class="form-horizontal update-profile" autocomplete="off">
    <div class="form-group">
      <label class="col-sm-2 control-label">Nama Perusahaan</label>
      <div class="col-sm-6">
        <input type="text" name="site_company" class="form-control" value="{{ $site_company }}" required="">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Nama Direktur</label>
      <div class="col-sm-6">
        <input type="text" name="site_director" class="form-control" value="{{ $site_director }}" required="">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Nama Manager</label>
      <div class="col-sm-6">
        <input type="text" name="site_manager" id="site_manager" class="form-control" value="{{ $site_manager }}" required="">
      </div>
    </div>
    
    <!-- /.box-body -->
    <div class="box-footer">
      <label class="col-sm-2 control-label"></label>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        @if($user->level == 1)
          <button type="submit" class="btn bg-blue"><i class="fa fa-check"></i> Simpan</button>
        @else
          <button type="button" class="btn bg-blue access-failed"><i class="fa fa-check"></i> Simpan</button>
        @endif
        <button type="reset" class="btn btn-danger btn-reset-profile">Reset Profil</button>
      </div>
    </div>
    <!-- /.box-footer -->
</form>