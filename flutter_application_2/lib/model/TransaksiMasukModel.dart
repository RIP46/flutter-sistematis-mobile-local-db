class TransaksiMasukModel {
  String? id_transaksi;
  String? nama_barang;
  String? tujuan;
  String? total_item;
  String? tgl_transaksi;
  String? keterangan;
  TransaksiMasukModel(this.id_transaksi, this.nama_barang, this.tujuan,
      this.total_item, this.tgl_transaksi, this.keterangan);
  TransaksiMasukModel.fromJson(Map<String, dynamic> json) {
    id_transaksi = json['id_transaksi'];
    nama_barang = json['nama_barang'];
    tujuan = json['tujuan'];
    total_item = json['total_item'];
    tgl_transaksi = json['tgl_transaksi'];
    keterangan = json['keterangan'];
  }
}