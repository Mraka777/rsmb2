<a href="#" id="help-popover" rel="popover" data-toggle="modal" data-target="#help-on-page" >
	<img src="/assets/images/clipart/help-icon.png" />
</a>

<!-- Modal -->
<div class="modal fade" id="help-on-page" tabindex="-1" role="dialog" aria-labelledby="HOPLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" class="bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="HOPLabel"><!-- Заголовок Хелпа --><?php print($page_help['help_topic']);?></h4>
      </div>
      <div class="modal-body">
				<!-- Текст хелпа --><?php
				print($page_help['help_text']);			 ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>