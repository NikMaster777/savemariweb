<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Creative Miles
 *@Start: 12th June 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>
<div class="panel-body">


<div class="row invoice-header">
  <div class="col-sm-6">
  	 <div class="btn-group">
  		<a href="<?php echo ADMINDOMAIN; ?>/?action=invoices&method=edit_invoice&client_id=<?php echo lib::get('client_id'); ?>" class="btn btn-default">Create Invoice</a>
    	<a href="#" class="btn btn-danger">Bulk Delete</a>
    </div>
  </div>
  <div class="col-sm-6">
  	<div class="btn-group pull-right">
		<?php echo $paginate->renderPages(); ?>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
  
    <?php if($records) { ?>
    	<div class="panel panel-default">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <td><input type="checkbox" value="" name="select_all" id="select_all"/></td>
                    <td>#</td>
                    <td>Invoice Date</td>
                    <td>Due Date</td>
                    <td>Published</td>
                    <td>Sub Total</td>
                    <td>Total</td>
                    <td>Status</td>
                    <td>Options</td>
                  </tr>
                </thead>
                <tbody>
                
                  <form action="" method="post" id="_delete-form">
					<?php while($invoiceData = db::fetch($invoiceSQL)) { ?>
                    <tr>
                      <td><input type="checkbox" value="" name="" class="checkbox"/></td>
                      <td><a href="<?php echo ADMINDOMAIN; ?>/?action=invoices&method=edit_invoice&invoice_id=<?php echo $invoiceData['invoice_id']; ?>"><?php echo $invoiceData['invoice_id']; ?></a></td>
                      <td><a href="<?php echo ADMINDOMAIN; ?>/?action=invoices&method=edit_invoice&invoice_id=<?php echo $invoiceData['invoice_id']; ?>"><?php echo date(lib::getDateFormat(), strtotime($invoiceData['invoice_date'])); ?></a></td>
                      <td><a href="<?php echo ADMINDOMAIN; ?>/?action=invoices&method=edit_invoice&invoice_id=<?php echo $invoiceData['invoice_id']; ?>"><?php echo date(lib::getDateFormat(), strtotime($invoiceData['invoice_duedate'])); ?></a></td>
                      <td><?php if($invoiceData['invoice_published']) { ?>Published<?php } else { ?>Not Published<?php } ?></td>
                      <td><?php echo lib::getCurrencyPrefix($invoiceData['invoice_currency'], number_format($invoiceData['invoice_subtotal'],2,'.','')); ?></td>
                      <td><?php echo lib::getCurrencyPrefix($invoiceData['invoice_currency'], number_format($invoiceData['invoice_total'],2,'.','')); ?></td>                      
                      <td><?php echo lib::getInvoiceStatus($invoiceData['invoice_status']); ?></td>
                      <td><a href="<?php echo ADMINDOMAIN; ?>/?action=invoices&method=edit_invoice&invoice_id=<?php echo $invoiceData['invoice_id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a> <a href="#" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-envelope"></span></a> <a href="#" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-file"></span></a> <a href="#" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-download-alt"></span></a> <a href="#" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-print"></span></a> <a href="#" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>
                    </tr>
                    <?php } ?>
                  </form>
                  
                </tbody>
                
              </table>
            </div>
        </div>
    <?php } else { ?>
    <div class="alert alert-warning">This client has no invoices to show, be the first to add one!</div>
    <?php } ?>
    
  </div>
</div>

</div>