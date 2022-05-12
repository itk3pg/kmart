<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <!--<li>
                <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>-->
			<?php if($this->session->userdata('group_kode') == "GRU0000" 
			|| $this->session->userdata('group_kode') == "GRU0003" 
			|| $this->session->userdata('group_kode') == "GRU0008" 
			|| $this->session->userdata('group_kode') == "GRU0011" 
			|| $this->session->userdata('username') == "KW94051" 
			|| $this->session->userdata('group_kode') == "GRU0007" 
			|| $this->session->userdata('group_kode') == "GRU0012" 
			|| $this->session->userdata('group_kode') == "GRU0009"){ ?>
            <li id="setting">
                <a href="#"><i class="fa fa-gear fa-fw"></i> Setting<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                	<!-- <li id="exportdbf">
                        <a href="<?php echo base_url(); ?>index.php/exportdbf">Export Data DBF</a>
                    </li> -->
					<li id="sinkronisasi">
                        <a href="<?php echo base_url(); ?>index.php/sinkronisasi">Sinkronisasi</a>
                    </li>
                    <!-- <li id="gantibarcode">
                        <a href="<?php echo base_url(); ?>index.php/gantibarcode">Perubahan Barcode</a>
                    </li> -->
					<!-- <li id="uploaddatatoko">
                        <a href="<?php echo base_url(); ?>index.php/uploaddatatoko">Upload Data Toko</a>
                    </li>
					<li id="importdatapenjualan">
                        <a href="<?php echo base_url(); ?>index.php/importdatapenjualan">Import Data Penjualan</a>
                    </li> -->
					<!-- <li id="setstockopname">
                        <a href="<?php echo base_url(); ?>index.php/setstockopname">Set Stock Opname</a>
                    </li> -->
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <?php } ?>
            <?php if($this->session->userdata('group_kode') == "GRU0000" 
			//|| $this->session->userdata('group_kode') == "GRU0001" 
			//|| $this->session->userdata('group_kode') == "GRU0002" 
			|| $this->session->userdata('group_kode') == "GRU0003" 
			|| $this->session->userdata('group_kode') == "GRU0004" 
			|| $this->session->userdata('group_kode') == "GRU0005" 
			|| $this->session->userdata('group_kode') == "GRU0006" 
			|| $this->session->userdata('group_kode') == "GRU0007" 
			|| $this->session->userdata('group_kode') == "GRU0008" 
			|| $this->session->userdata('group_kode') == "GRU0009" 
			|| $this->session->userdata('group_kode') == "GRU0010" 
			|| $this->session->userdata('group_kode') == "GRU0012"){ ?>
            <li id="master">
                <a href="#"><i class="fa fa-table fa-fw"></i> Master<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
					<?php if($this->session->userdata('group_kode') == "GRU0000" 
					|| $this->session->userdata('group_kode') == "GRU0003"){ ?>
					<li id="user">
                        <a href="<?php echo base_url(); ?>index.php/user">User</a>
                    </li>
					<?php } ?>
                    <li id="kategoribarang">
                        <a href="<?php echo base_url(); ?>index.php/kategoribarang">Kelompok Barang</a>
                    </li>
                    <!-- <li id="tipepembayaran">
                        <a href="<?php echo base_url(); ?>index.php/tipepembayaran">Tipe Pembayaran</a>
                    </li> -->
                    <li id="pelanggan">
                        <a href="<?php echo base_url(); ?>index.php/pelanggan">Pelanggan</a>
                    </li>
                    <li id="supplier">
                        <a href="<?php echo base_url(); ?>index.php/supplier">Supplier</a>
                    </li>
                    <li id="toko">
                        <a href="<?php echo base_url(); ?>index.php/toko">Toko</a>
                    </li>
                    <li id="barang">
                        <a href="<?php echo base_url(); ?>index.php/barang">Barang</a>
                    </li>
					<li id="promo">
                        <a href="<?php echo base_url(); ?>index.php/promo">Promo</a>
                    </li>
					<li id="planogram">
                        <a href="<?php echo base_url(); ?>index.php/planogram">Planogram</a>
                    </li>
                    <li id="minmax">
                        <a href="<?php echo base_url(); ?>index.php/minmax">Min-Max</a>
                    </li>
                    <!-- <li id="m_kasbank">
                        <a href="<?php echo base_url(); ?>index.php/m_kasbank">KasBank</a>
                    </li>
                    <li id="m_cashbudget">
                        <a href="<?php echo base_url(); ?>index.php/m_cashbudget">Cash Budget</a>
                    </li> -->
                    <li id="m_bank">
                        <a href="<?php echo base_url(); ?>index.php/m_bank">Data Bank</a>
                    </li>
                    <li id="m_alasanretur">
                        <a href="<?php echo base_url(); ?>index.php/m_alasanretur">Alasan Retur</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <?php } ?>
            <?php if($this->session->userdata('group_kode') == "GRU0000" 
			|| $this->session->userdata('group_kode') == "GRU0001" 
			|| $this->session->userdata('group_kode') == "GRU0002" 
			|| $this->session->userdata('group_kode') == "GRU0003" 
			|| $this->session->userdata('group_kode') == "GRU0004" 
			|| $this->session->userdata('group_kode') == "GRU0005" 
			|| $this->session->userdata('group_kode') == "GRU0006" 
			|| $this->session->userdata('group_kode') == "GRU0008" 
			|| $this->session->userdata('group_kode') == "GRU0009" 
			|| $this->session->userdata('group_kode') == "GRU0010" 
			|| $this->session->userdata('group_kode') == "GRU0011" 
			|| $this->session->userdata('group_kode') == "GRU0012" 
			|| $this->session->userdata('group_kode') == "GRU0007"){ ?>
            <li id="transaksi">
                <a href="#"><i class="fa fa-money fa-fw"></i> Transaksi<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
					<?php if($this->session->userdata('group_kode') == "GRU0000" 
					|| $this->session->userdata('group_kode') == "GRU0003" 
					|| $this->session->userdata('group_kode') == "GRU0009" 
					|| $this->session->userdata('group_kode') == "GRU0008" 
					|| $this->session->userdata('group_kode') == "GRU0006" 
					|| $this->session->userdata('group_kode') == "GRU0007"){ ?>
					<li id="orderpembelian">
                        <a href="<?php echo base_url(); ?>index.php/orderpembelian">Order Pembelian (OP)</a>
                    </li>
					<li id="pembelianbarang">
                        <a href="<?php echo base_url(); ?>index.php/pembelianbarang">Pengadaan Barang (BI)</a>
                    </li>
					<li id="taukeluar">
                        <a href="<?php echo base_url(); ?>index.php/taukeluar">Biaya Keluar (TK)</a>
                    </li>
					<?php } ?>
					<?php if($this->session->userdata('group_kode') == "GRU0000" 
					|| $this->session->userdata('group_kode') == "GRU0003" 
					|| $this->session->userdata('group_kode') == "GRU0009" 
					|| $this->session->userdata('group_kode') == "GRU0001" 
					|| $this->session->userdata('group_kode') == "GRU0002" 
					|| $this->session->userdata('group_kode') == "GRU0004" 
					|| $this->session->userdata('group_kode') == "GRU0005" 
					|| $this->session->userdata('group_kode') == "GRU0012" 
					|| $this->session->userdata('group_kode') == "GRU0006" 
					|| $this->session->userdata('group_kode') == "GRU0007"){ ?>
					<li id="ordertransfer">
                        <a href="<?php echo base_url(); ?>index.php/ordertransfer">Permintaan Transfer Toko (OT)</a>
                    </li>
					<li id="transfergudang">
                        <a href="<?php echo base_url(); ?>index.php/transfergudang">Transfer Toko (TG)</a>
                    </li>
					<?php } ?>
					<?php if($this->session->userdata('group_kode') == "GRU0000" 
					|| $this->session->userdata('group_kode') == "GRU0003" 
					|| $this->session->userdata('group_kode') == "GRU0009" 
					|| $this->session->userdata('group_kode') == "GRU0008" 
					|| $this->session->userdata('group_kode') == "GRU0006" 
					|| $this->session->userdata('group_kode') == "GRU0007"){ ?>
					<!-- <li id="badstock">
                        <a href="<?php echo base_url(); ?>index.php/badstock">Bad Stock (BS)</a>
                    </li>
                    <li id="transferbadstock">
                        <a href="<?php echo base_url(); ?>index.php/transferbadstock">Transfer Bad Stock (TB)</a>
                    </li> -->
					<?php } ?>
					<?php if($this->session->userdata('group_kode') == "GRU0000" 
					|| $this->session->userdata('group_kode') == "GRU0001" 
					|| $this->session->userdata('group_kode') == "GRU0002" 
					|| $this->session->userdata('group_kode') == "GRU0003" 
					|| $this->session->userdata('group_kode') == "GRU0004" 
					|| $this->session->userdata('group_kode') == "GRU0005" 
					|| $this->session->userdata('group_kode') == "GRU0009" 
					|| $this->session->userdata('group_kode') == "GRU0012" 
					|| $this->session->userdata('group_kode') == "GRU0006" 
					|| $this->session->userdata('group_kode') == "GRU0007"){ ?>
					<li id="returtoko">
                        <a href="<?php echo base_url(); ?>index.php/returtoko">Retur Toko (RT)</a>
                    </li>
                    <li id="penjualannontunai">
                        <a href="<?php echo base_url(); ?>index.php/penjualannontunai">Penjualan Non Tunai</a>
                    </li>
					<?php } ?>
					<?php if($this->session->userdata('group_kode') == "GRU0000" 
					|| $this->session->userdata('group_kode') == "GRU0003" 
					|| $this->session->userdata('group_kode') == "GRU0009" 
					|| $this->session->userdata('group_kode') == "GRU0008" 
					|| $this->session->userdata('group_kode') == "GRU0006" 
					|| $this->session->userdata('group_kode') == "GRU0007"){ ?>
					<li id="retursupplier">
                        <a href="<?php echo base_url(); ?>index.php/retursupplier">Retur Supplier (RS)</a>
                    </li>
					<?php } ?>
					<!--<li id="penjualannontunai">
                        <a href="<?php echo base_url(); ?>index.php/penjualannontunai">Penjualan Non Tunai</a>
                    </li>-->
					<?php if($this->session->userdata('group_kode') == "GRU0000" || $this->session->userdata('group_kode') == "GRU0008" || $this->session->userdata('group_kode') == "GRU0012"){ ?>
                    <li id="hutang">
                        <a href="<?php echo base_url(); ?>index.php/hutang">Hutang</a>
                    </li>
					<li id="hutangpenyesuaian">
                        <a href="<?php echo base_url(); ?>index.php/hutangpenyesuaian">Penyesuaian Hutang</a>
                    </li>
                    <?php } ?>
                    <?php if($this->session->userdata('group_kode') == "GRU0000" 
					|| $this->session->userdata('group_kode') == "GRU0008" 
					|| $this->session->userdata('group_kode') == "GRU0012" 
					|| $this->session->userdata('group_kode') == "GRU0010" 
					|| $this->session->userdata('group_kode') == "GRU0007" 
					|| $this->session->userdata('username') == "402" 
					|| $this->session->userdata('username') == "ANGGAR"){ ?>
					<li id="pendapatanlain">
                        <a href="<?php echo base_url(); ?>index.php/pendapatanlain">Pendapatan Lain-Lain</a>
                    </li>
                    <?php } ?>
                    <?php if($this->session->userdata('group_kode') == "GRU0000" 
					|| $this->session->userdata('group_kode') == "GRU0008" 
					|| $this->session->userdata('group_kode') == "GRU0012"){ ?>
					<li id="piutang">
                        <a href="<?php echo base_url(); ?>index.php/piutang">Piutang</a>
                    </li>
					<li id="tukarnota">
                        <a href="<?php echo base_url(); ?>index.php/tukarnota">Tukar Nota (TT)</a>
                    </li>
					<?php } ?>
					<?php if($this->session->userdata('group_kode') == "GRU0000" 
					|| $this->session->userdata('group_kode') == "GRU0008" 
					|| $this->session->userdata('group_kode') == "GRU0012"  
					|| $this->session->userdata('group_kode') == "GRU0005"){ ?>
					<!-- <li id="kasbank">
                        <a href="<?php echo base_url(); ?>index.php/kasbank">Kas/Bank</a>
                    </li> -->
					<?php } ?>
					<?php if($this->session->userdata('group_kode') == "GRU0000" 
					|| $this->session->userdata('group_kode') == "GRU0008" 
					|| $this->session->userdata('group_kode') == "GRU0010" 
					|| $this->session->userdata('group_kode') == "GRU0011" 
					|| $this->session->userdata('group_kode') == "GRU0012" 
					|| $this->session->userdata('group_kode') == "GRU0007" 
					|| $this->session->userdata('username') == "402" 
					|| $this->session->userdata('username') == "403"){ ?>
					<li id="permintaanpembayaran">
                        <a href="<?php echo base_url(); ?>index.php/permintaanpembayaran">Permintaan Pembayaran (PB)</a>
                    </li>
					<?php } ?>
					<?php if($this->session->userdata('group_kode') == "GRU0000" 
					|| $this->session->userdata('group_kode') == "GRU0008" 
					|| $this->session->userdata('group_kode') == "GRU0010" 
					|| $this->session->userdata('group_kode') == "GRU0011" 
					|| $this->session->userdata('group_kode') == "GRU0012" 
					|| $this->session->userdata('group_kode') == "GRU0006" 
					|| $this->session->userdata('group_kode') == "GRU0007"){ ?>
					<!-- <li id="droppingkaskecil">
                        <a href="<?php echo base_url(); ?>index.php/droppingkaskecil">Dropping Kas Kecil</a>
                    </li> -->
					<?php } ?>
					<li id="stockopname">
                        <a href="<?php echo base_url(); ?>index.php/stockopname">Stock Opname</a>
                    </li>
					<!-- <li id="jatahairminum">
                        <a href="<?php echo base_url(); ?>index.php/jatahairminum">Jatah Air Minum</a>
                    </li> -->
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <?php } ?>
            <?php if($this->session->userdata('group_kode') == "GRU0000" 
			//|| $this->session->userdata('group_kode') == "GRU0001" 
			|| $this->session->userdata('group_kode') == "GRU0002" 
			|| $this->session->userdata('group_kode') == "GRU0003" 
			|| $this->session->userdata('group_kode') == "GRU0004" 
			|| $this->session->userdata('group_kode') == "GRU0005" 
			|| $this->session->userdata('group_kode') == "GRU0006" 
			|| $this->session->userdata('group_kode') == "GRU0008" 
			|| $this->session->userdata('group_kode') == "GRU0009" 
			|| $this->session->userdata('group_kode') == "GRU0010" 
			|| $this->session->userdata('group_kode') == "GRU0011" 
			|| $this->session->userdata('group_kode') == "GRU0012" 
			|| $this->session->userdata('group_kode') == "GRU0007"){ ?>
            <li id="konsinyasi">
                <a href="#"><i class="fa fa-money fa-fw"></i> Konsinyasi<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <?php if($this->session->userdata('group_kode') == "GRU0000" 
					|| $this->session->userdata('group_kode') == "GRU0003" 
					|| $this->session->userdata('group_kode') == "GRU0009" 
					|| $this->session->userdata('group_kode') == "GRU0008" 
					|| $this->session->userdata('group_kode') == "GRU0006" 
					|| $this->session->userdata('group_kode') == "GRU0007" 
					|| $this->session->userdata('group_kode') == "GRU0012"){ ?>
                    <li id="pembelianbarangkonsinyasi">
                        <a href="<?php echo base_url(); ?>index.php/pembelianbarangkonsinyasi">Pengadaan Barang Konsinyasi (KN)</a>
                    </li>
                    <?php } ?>
                    <?php if($this->session->userdata('group_kode') == "GRU0000" 
					|| $this->session->userdata('group_kode') == "GRU0003" 
					|| $this->session->userdata('group_kode') == "GRU0009" 
					|| $this->session->userdata('group_kode') == "GRU0008" 
					|| $this->session->userdata('group_kode') == "GRU0006" 
					|| $this->session->userdata('group_kode') == "GRU0007" 
					|| $this->session->userdata('group_kode') == "GRU0012"){ ?>
                    <li id="retursupplierkonsinyasi">
                        <a href="<?php echo base_url(); ?>index.php/retursupplierkonsinyasi">Retur Supplier Konsinyasi (RN)</a>
                    </li>
                    <?php } ?>
                    <?php if($this->session->userdata('group_kode') == "GRU0000" 
					|| $this->session->userdata('group_kode') == "GRU0003" 
					|| $this->session->userdata('group_kode') == "GRU0009" 
					|| $this->session->userdata('group_kode') == "GRU0001" 
					|| $this->session->userdata('group_kode') == "GRU0002" 
					|| $this->session->userdata('group_kode') == "GRU0004" 
					|| $this->session->userdata('group_kode') == "GRU0005" 
					|| $this->session->userdata('group_kode') == "GRU0012" 
					|| $this->session->userdata('group_kode') == "GRU0006" 
					|| $this->session->userdata('group_kode') == "GRU0007"){ ?>
                    <li id="transfergudangkonsinyasi">
                        <a href="<?php echo base_url(); ?>index.php/transfergudangkonsinyasi">Transfer Toko Konsinyasi (TN)</a>
                    </li>
                    <?php } ?>
                    <?php if($this->session->userdata('group_kode') == "GRU0000" 
					|| $this->session->userdata('group_kode') == "GRU0001" 
					|| $this->session->userdata('group_kode') == "GRU0002" 
					|| $this->session->userdata('group_kode') == "GRU0003" 
					|| $this->session->userdata('group_kode') == "GRU0004" 
					|| $this->session->userdata('group_kode') == "GRU0005" 
					|| $this->session->userdata('group_kode') == "GRU0009" 
					|| $this->session->userdata('group_kode') == "GRU0012" 
					|| $this->session->userdata('group_kode') == "GRU0006" 
					|| $this->session->userdata('group_kode') == "GRU0007"){ ?>
                    <li id="returtokokonsinyasi">
                        <a href="<?php echo base_url(); ?>index.php/returtokokonsinyasi">Retur Toko Konsinyasi (UN)</a>
                    </li>
                    <?php } ?>
                    <?php if($this->session->userdata('group_kode') == "GRU0000" 
					|| $this->session->userdata('group_kode') == "GRU0001" 
					|| $this->session->userdata('group_kode') == "GRU0002" 
					|| $this->session->userdata('group_kode') == "GRU0003" 
					|| $this->session->userdata('group_kode') == "GRU0004" 
					|| $this->session->userdata('group_kode') == "GRU0005" 
					|| $this->session->userdata('group_kode') == "GRU0009" 
					|| $this->session->userdata('group_kode') == "GRU0012" 
					|| $this->session->userdata('group_kode') == "GRU0006" 
					|| $this->session->userdata('group_kode') == "GRU0007"){ ?>
                    <li id="taukeluarkonsinyasi">
                        <a href="<?php echo base_url(); ?>index.php/taukeluarkonsinyasi">Biaya Keluar Konsinyasi (YN)</a>
                    </li>
                    <?php } ?>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <?php } ?>
            <?php if($this->session->userdata('group_kode') == "GRU0000" 
			|| $this->session->userdata('group_kode') == "GRU0001" 
			|| $this->session->userdata('group_kode') == "GRU0002" 
			|| $this->session->userdata('group_kode') == "GRU0003" 
			|| $this->session->userdata('group_kode') == "GRU0004" 
			|| $this->session->userdata('group_kode') == "GRU0005" 
			|| $this->session->userdata('group_kode') == "GRU0006" 
			|| $this->session->userdata('group_kode') == "GRU0007" 
			|| $this->session->userdata('group_kode') == "GRU0008" 
			|| $this->session->userdata('group_kode') == "GRU0009" 
			|| $this->session->userdata('group_kode') == "GRU0010" 
			|| $this->session->userdata('group_kode') == "GRU0011" 
			|| $this->session->userdata('group_kode') == "GRU0012" 
			|| $this->session->userdata('group_kode') == "GRU0013"){ ?>
            <li id="laporan">
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Laporan<span class="fa arrow"></span></a>
                <ul id="ullaporan" class="nav nav-second-level">
					<li id="lappenjualan">
						<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Penjualan <span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">
							<li id="penjualankreditanggota">
								<a href="<?php echo base_url(); ?>index.php/laporan/penjualankreditanggota">Penjualan Kredit Anggota</a>
							</li>
							<li id="penjualankreditinstansi">
								<a href="<?php echo base_url(); ?>index.php/laporan/penjualankreditinstansi">Penjualan Kredit Instansi</a>
							</li>
							<li id="omzetppn">
								<a href="<?php echo base_url(); ?>index.php/laporan/omzetppn">Omzet dan PPN Keluaran</a>
							</li>
							<li id="omzethpp">
								<a href="<?php echo base_url(); ?>index.php/laporan/omzethpp">Omzet dan HPP</a>
							</li>
							<li id="penjualanperbarang">
								<a href="<?php echo base_url(); ?>index.php/laporan/penjualanperbarang">Data Penjualan Per Barang</a>
							</li>
							<li id="barangtidakterjual">
								<a href="<?php echo base_url(); ?>index.php/laporan/barangtidakterjual">Data Barang Tidak Terjual</a>
							</li>
							<li id="transaksipenjualan">
								<a href="<?php echo base_url(); ?>index.php/laporan/transaksipenjualan">Transaksi Penjualan</a>
							</li>
							<li id="detailpenjualanharian">
								<a href="<?php echo base_url(); ?>index.php/laporan/detailpenjualanharian">Detail Penjualan Harian</a>
							</li>
							<li id="detailpenjualanbulanan">
								<a href="<?php echo base_url(); ?>index.php/laporan/detailpenjualanbulanan">Penjualan Bulanan</a>
							</li>
                            <li id="rekappenjualannonanggota">
                                <a href="<?php echo base_url(); ?>index.php/laporan/rekappenjualannonanggota">Penjualan Non Anggota</a>
                            </li>
                            <!--<li id="penjualankonsinyasi">
                                <a href="<?php echo base_url(); ?>index.php/laporan/penjualankonsinyasi">Penjualan Konsinyasi</a>
                            </li> -->
							<li id="rekapbarangpenjualan">
								<a href="<?php echo base_url(); ?>index.php/laporan/rekapbarangpenjualan">Rekap Detail Penjualan</a>
							</li>
							<li id="promoaktif">
								<a href="<?php echo base_url(); ?>index.php/laporan/promoaktif">Rekap Promo Aktif</a>
							</li>
                            <!-- <li id="laporanfeepulsa">
                                <a href="<?php echo base_url(); ?>index.php/laporan/laporanfeepln">Fee Voucher PLN</a>
                            </li> -->
						</ul>
					</li>
					<!-- <li id="lapkasbank">
						<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Kasbank <span class="fa arrow"></span></a>
						<ul class="nav nav-third-level"> -->
							<!-- <li id="mutasikasbank">
								<a href="<?php echo base_url(); ?>index.php/laporan/mutasikasbank">Mutasi Kas/Bank</a>
							</li>
							<li id="mutasicashbudget">
								<a href="<?php echo base_url(); ?>index.php/laporan/mutasicashbudget">Mutasi Cash Budget</a>
							</li> -->
							<!-- <li id="kaskecilmini">
								<a href="<?php echo base_url(); ?>index.php/laporan/kaskecilmini">Biaya Operasional</a>
							</li> -->
						<!-- </ul>
					</li> -->
					<li id="laphutang">
						<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Hutang <span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">
							<li id="mutasihutang">
								<a href="<?php echo base_url(); ?>index.php/laporan/mutasihutang">Mutasi Hutang</a>
							</li>
							<li id="kartuhutang">
								<a href="<?php echo base_url(); ?>index.php/laporan/kartuhutang">Kartu Hutang</a>
							</li>
						</ul>
					</li>
					<li id="lappiutang">
						<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Piutang <span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">
							<li id="rekappiutanginstansi">
								<a href="<?php echo base_url(); ?>index.php/laporan/rekappiutanginstansi">Rekap Piutang Instansi</a>
							</li>
							<li id="mutasipiutang">
								<a href="<?php echo base_url(); ?>index.php/laporan/mutasipiutang">Mutasi Piutang</a>
							</li>
							<li id="rincianpiutang">
								<a href="<?php echo base_url(); ?>index.php/laporan/rincianpiutang">Kartu Piutang</a>
							</li>
							<li id="umurpiutang">
								<a href="<?php echo base_url(); ?>index.php/laporan/umurpiutang">Umur Piutang</a>
							</li>
						</ul>
					</li>
					<li id="lappersediaan">
						<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Persediaan <span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">
							<li id="mutasibarang">
								<a href="<?php echo base_url(); ?>index.php/laporan/mutasibarang">Mutasi Barang All</a>
							</li>
							<li id="saldobaranggudang">
								<a href="<?php echo base_url(); ?>index.php/laporan/saldobaranggudang">Saldo Barang Toko</a>
							</li>
							<li id="hargabarangtoko">
								<a href="<?php echo base_url(); ?>index.php/laporan/hargabarangtoko">Harga Jual Toko</a>
							</li>
							<li id="perubahanharga">
								<a href="<?php echo base_url(); ?>index.php/laporan/perubahanharga">Perubahan Harga</a>
							</li>
							<li id="databarangpos">
								<a href="<?php echo base_url(); ?>index.php/laporan/databarangpos">Data Barang POS</a>
							</li>
							<li id="databarangsupplier">
								<a href="<?php echo base_url(); ?>index.php/laporan/databarangsupplier">Data Barang Supplier</a>
							</li>
							<li id="barangmasuk">
								<a href="<?php echo base_url(); ?>index.php/laporan/barangmasuk">Pengadaan Barang</a>
							</li>
							<li id="perubahanhargabeli">
								<a href="<?php echo base_url(); ?>index.php/laporan/perubahanhargabeli">Perubahan Harga Beli</a>
							</li>
							<li id="rekapretursupplier">
								<a href="<?php echo base_url(); ?>index.php/laporan/rekapretursupplier">Rekap Retur Supplier</a>
							</li>
							<li id="taukeluar">
								<a href="<?php echo base_url(); ?>index.php/laporan/taukeluar">Biaya Keluar</a>
							</li>
							<!-- <li id="analisapembeliantunai">
								<a href="<?php echo base_url(); ?>index.php/laporan/analisapembeliantunai">Analisa Pembelian Tunai & Kasbank</a>
							</li> -->
                            <!-- <li id="laporanpulsa">
                                <a href="<?php echo base_url(); ?>index.php/laporan/laporanpulsa">Perbandingan BO-BI Pulsa</a>
                            </li> -->
						</ul>
					</li>
                    <li id="lappersediaankonsinyasi">
                        <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Konsinyasi <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li id="saldobarangkonsinyasi">
                                <a href="<?php echo base_url(); ?>index.php/laporan/saldobaranggudangkonsinyasi">Saldo Barang Konsinyasi</a>
                            </li>
                            <li id="baranglakukonsinyasi">
                                <a href="<?php echo base_url(); ?>index.php/laporan/baranglakukonsinyasi">Barang Laku</a>
                            </li>
                            <li id="rekapitulasibarangkonsinyasi">
                                <a href="<?php echo base_url(); ?>index.php/laporan/rekapitulasibarangkonsinyasi">Rekapitulasi Barang Konsinyasi</a>
                            </li>
                        </ul>
                    </li>
					<li id="lapstockopname">
						<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Stock Opname <span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">
							<li id="mutasibarang">
								<a href="<?php echo base_url(); ?>index.php/laporan/stockopname">Hasil Stock Opname</a>
							</li>
						</ul>
					</li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <?php } ?>
			<!-- <li id="jurnal">
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Jurnal<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li id="piutanganggota">
                        <a href="<?php echo base_url(); ?>index.php/jurnal/piutanganggota">Jurnal Kredit Anggota</a>
                    </li>
				</ul>
			</li> -->
        </ul>
        <!-- /#side-menu -->
    </div>
    <!-- /.sidebar-collapse -->
</nav>
<!-- /.navbar-static-side -->