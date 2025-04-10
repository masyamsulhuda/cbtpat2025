<div class="page-inner">
	<div class="row">
		<?php
		foreach ($hasil as $n) {
			$nilai = ceil($n->nilai); ?>
			<div class="col-12 col-sm-6 col-md-3">
				<div class="card">
					<div class="card-body">
						<div class="d-flex justify-content-between">
							<div class="mb-0">
								<h5 class="mb-0"><b><?php echo $n->nama_ujian ?></b></h5>
								<p class="text-muted small"><i class="fas fa-id-badge"></i> <?php echo $n->nama; ?></p>
							</div>
						</div>
						<?php if ($aplikasi['ujian_nilai'] == 1) { ?>
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
						<?php } else { ?>
							<div class="d-flex justify-content-between">
								<p class="text-muted small fw-bold mb-0"><i class="fas fa-signature"></i> Status</p>
								<p class="badge badge-danger small fw-bold mb-0">Selesai</p>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php }  ?>
	</div>
</div>