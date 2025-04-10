<div class="page-inner">
	<div class="alert alert-success mb-4">
		<h3 class="fw-bold h3 pd-2 text-success"><i class="fas fa-check-circle"></i> Status Ujian Anda!</h3>
		<?php echo $data; ?>
		<?php if ($aplikasi['ujian_nilai'] == 0) {
		} else { ?>
			<hr>
			<div class="row mt-4">
				<?php
				foreach ($hasil as $n) {
					$nilai = ceil($n->nilai); ?>
					<div class="col-12 col-sm-6 col-md-3">
						<div class="card mb-2">
							<div class="card-body">
								<div class="d-flex justify-content-between">
									<div class="mb-0">
										<h5 class="mb-0"><b><?php echo $n->nama_ujian ?></b></h5>
										<p class="text-muted small"><i class="fas fa-id-badge"></i> <?php echo $n->nama; ?></p>
									</div>
								</div>
								<div class="progress progress-sm mb-1">
									<?php if ($nilai <= 20) {
										echo "<div class='progress-bar bg-danger w-25' role='progressbar'></div>";
									} elseif ($nilai <= 50) {
										echo "<div class='progress-bar bg-warning w-50' role='progressbar'></div>";
									} elseif ($nilai <= 75) {
										echo "<div class='progress-bar bg-primary w-75' role='progressbar'></div>";
									} else {
										echo "<div class='progress-bar bg-success w-100' role='progressbar'></div>";
									}
									?>
								</div>
								<div class="d-flex justify-content-between">
									<p class="text-muted small fw-bold mb-0"><i class="fas fa-signature"></i> Nilai</p>
									<p class="text-muted small fw-bold mb-0"><?php echo $n->nilai; ?></p>
								</div>
							</div>
						</div>
					</div>
				<?php }  ?>
			</div>
		<?php } ?>
	</div>
</div>