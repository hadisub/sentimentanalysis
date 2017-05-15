<!--TABEL DATA UJI -->
<div class="row">
    <div class="col-md-12">
    <!-- Advanced Tables -->
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th width="25%">Judul Review</th>
                            <th>Label Awal</th>
                            <th>P <em>Pos</em></th>
                            <th>P <em>Neg</em></th>
                            <th>Hasil Analisis</th>
                            <th>Hasil</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!--End Advanced Tables -->
	<div class="col-md-12" id="confusion-matrix">
		<!--Confusion Matrix-->
		<div class="alert alert-info">
				<p class="text-center" style="padding-top:0;padding-bottom:10px;"><strong>Confusion Matrix</strong></p>
				<div class="table-responsive">
					<table class="table table-bordered">
						<tr>
							<td>Jumlah Data Uji : <span id="total-datauji"></span></td>
							<td><strong>Hasil Analisis POSITIF</strong></td>
							<td><strong>Hasil Analisis NEGATIF</strong></td>
						</tr>
						<tr>
							<td><strong>Label Awal POSITIF</strong></td>
							<td><strong>T</strong>rue <strong>P</strong>ositives = <span id="true-positives"></span></td>
							<td><strong>F</strong>alse <strong>N</strong>egatives = <span id="false-negatives"></span></td>
						</tr>
						<tr>
							<td><strong>Label Awal NEGATIF</strong></td>
							<td><strong>F</strong>alse <strong>P</strong>ositives = <span id="false-positives"></span></td>
							<td><strong>T</strong>rue <strong>N</strong>egatives = <span id="true-negatives"></span></td>
						</tr>
					</table>
				</div>
        </div>
		<div class="alert alert-info">
			<table class="borderless">
				<th width="310"><strong>Akurasi (TP+TN/Total Prediksi)</strong></th>
				<th width="20">=</th>
				<th><span id="akurasi-percentage"></span></th>
			</table>
		</div>
		<div class="alert alert-info">
			<table class="borderless">
				<th width="310"><strong>Error Rate (1 - Akurasi)</strong></th>
				<th width="20">=</th>
				<th><span id="error-rate"></span></th>
			</table>
		</div>
		<div class="alert alert-info">
			<table class="borderless">
				<th width="310"><strong>Presisi (TP/TP+FP)</strong></th>
				<th width="20">=</th>
				<th><span id="presisi"></span></th>
			</table>
		</div>
		<div class="alert alert-info">
			<table class="borderless">
				<th width="310"><strong>Recall (TP/TP+FN)</strong></th>
				<th width="20">=</th>
				<th><span id="recall"></span></th>
			</table>
		</div>
		<!--End COnfusion Matrix-->
	</div>
</div>
