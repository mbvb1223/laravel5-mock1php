@if (isset($errors) && $errors != null)
  @if ($errors->any())
  <div id="prefix_632452753790" class="Metronic-alerts alert alert-danger fade in">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><i class="fa-lg fa fa-warning"></i>
      <?php echo Lang::get('messages.error'); ?>
     <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
     </ul>
  </div>
  @elseif (Session::get('success'))
  <div class="note note-success">
     <p>
         <?php echo Lang::get('messages.success');  ?>: {{ Session::get('success') }}
     </p>
  </div>
  @endif
@endif