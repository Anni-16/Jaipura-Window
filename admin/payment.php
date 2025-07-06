<?php require_once('header.php'); ?>
<?php require_once('inc/functions.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Payments</h1>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th width="30">S.No</th>
								<th width="100">Order ID</th>
								<th width="100">Payment ID</th>
								<th width="150">Customer Name</th>
								<th width="150">Customer Email</th>
								<th width="150">Customer Phone</th>
								<th width="200">Customer Address</th>
								<th width="100">Product Size</th>
								<th width="100">Product Color</th>
								<th width="100">Paid Amount</th>
								<th width="120">Payment Date</th>
								<th width="100">Payment Status</th>
								<th width="80">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							$statement = $pdo->prepare("
                                SELECT p.id, p.order_id, p.txnid AS payment_id, p.customer_name, p.customer_email, p.customer_phone, p.customer_address, p.paid_amount, p.payment_date, p.payment_status, p.created_on,
                                       s.size_name, cl.color_name
                                FROM tbl_payment p
                                LEFT JOIN tbl_order o ON p.order_id = o.order_id
                                LEFT JOIN tbl_size s ON o.size = s.size_id
                                LEFT JOIN tbl_color cl ON o.color = cl.color_id
                                GROUP BY p.id
                                ORDER BY p.id DESC
                            ");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);

							foreach ($result as $row) {
								$i++;
							?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo htmlspecialchars($row['order_id'] ?: 'N/A'); ?></td>
									<td><?php echo htmlspecialchars($row['payment_id'] ?: 'N/A'); ?></td>
									<td><?php echo htmlspecialchars(limit_words($row['customer_name'] ?: 'N/A', 20)); ?></td>
									<td><?php echo htmlspecialchars(limit_words($row['customer_email'] ?: 'N/A', 20)); ?></td>
									<td><?php echo htmlspecialchars($row['customer_phone'] ?: 'N/A'); ?></td>
									<td><?php echo htmlspecialchars(limit_words($row['customer_address'] ?: 'N/A', 20)); ?></td>
									<td><?php echo htmlspecialchars($row['size_name'] ?: 'N/A'); ?></td>
									<td><?php echo htmlspecialchars($row['color_name'] ?: 'N/A'); ?></td>
									<td><?php echo htmlspecialchars($row['paid_amount'] ?: 'N/A'); ?></td>
									<td><?php echo htmlspecialchars($row['payment_date'] ?: 'N/A'); ?></td>
									<td class="<?php echo ($row['payment_status'] == 'Paid') ? 'text-success' : 'text-danger'; ?>">
										<?php echo htmlspecialchars($row['payment_status'] ?: 'N/A'); ?>
									</td>
									<td>
										<button type="button" onclick="printPaymentRow(<?php echo $i; ?>)" class="btn btn-sm btn-primary">Print</button>
									</td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- JavaScript for Print Function -->
<script>
	function printPaymentRow(rowIndex) {
		try {
			var table = document.querySelector('#example1');
			if (!table) {
				alert('Error: Table not found');
				return;
			}

			var row = table.getElementsByTagName('tr')[rowIndex];
			if (!row) {
				alert('Error: Row not found');
				return;
			}

			var cells = row.getElementsByTagName('td');
			if (cells.length < 14) {
				alert('Error: Invalid row data');
				return;
			}

			var data = {
				sno: cells[0].innerText || 'N/A',
				orderId: cells[1].innerText || 'N/A',
				paymentId: cells[2].innerText || 'N/A',
				customerName: cells[3].innerText || 'N/A',
				customerEmail: cells[4].innerText || 'N/A',
				customerPhone: cells[5].innerText || 'N/A',
				customerAddress: cells[6].innerText || 'N/A',
				size: cells[7].innerText || 'N/A',
				color: cells[8].innerText || 'N/A',
				paidAmount: cells[9].innerText || 'N/A',
				paymentDate: cells[10].innerText || 'N/A',
				paymentStatus: cells[11].innerText || 'N/A',
			};

			var printWindow = window.open('', '_blank', 'width=800,height=600');
			printWindow.document.write(`
            <html>
            <head>
                <title>Print Payment Details</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    h2 { margin-bottom: 10px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                </style>
            </head>
            <body>
                <h2>Payment Details</h2>
                <p>Printed on: ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}</p>
                <table>
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Order ID</th>
                            <th>Payment ID</th>
                            <th>Customer Name</th>
                            <th>Customer Email</th>
                            <th>Customer Phone</th>
                            <th>Customer Address</th>
                            <th>Product Size</th>
                            <th>Product Color</th>
                            <th>Paid Amount</th>
                            <th>Payment Date</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>${data.sno}</td>
                            <td>${data.orderId}</td>
                            <td>${data.paymentId}</td>
                            <td>${data.customerName}</td>
                            <td>${data.customerEmail}</td>
                            <td>${data.customerPhone}</td>
                            <td>${data.customerAddress}</td>
                            <td>${data.size}</td>
                            <td>${data.color}</td>
                            <td>${data.paidAmount}</td>
                            <td>${data.paymentDate}</td>
                            <td>${data.paymentStatus}</td>
                        </tr>
                    </tbody>
                </table>
            </body>
            </html>
        `);
			printWindow.document.close();
			printWindow.focus();
			setTimeout(() => {
				printWindow.print();
				printWindow.close();
			}, 500);
		} catch (error) {
			console.error('Print error:', error);
			alert('Error printing payment. Please try again.');
		}
	}
</script>


<?php require_once('footer.php'); ?>