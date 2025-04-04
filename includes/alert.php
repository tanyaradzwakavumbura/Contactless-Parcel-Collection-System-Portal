<?php
if(isset($message))
{
?>
<div class="<?php echo $alert;?>" role="alert">
    <strong><?php echo $message;?></strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<?php
}
?> 