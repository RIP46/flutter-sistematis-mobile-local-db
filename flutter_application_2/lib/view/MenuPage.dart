import 'dart:convert';
import 'package:flutter_application_2/model/CountData.dart';
import 'package:awesome_dialog/awesome_dialog.dart';
import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:flutter_application_2/model/api.dart';
import 'package:flutter_application_2/view/admin/DataAdmin.dart';
import 'package:flutter_application_2/view/jenis/DataJenis.dart';
import 'package:flutter_application_2/view/barang/DataBarang.dart';
import 'package:flutter_application_2/view/tujuan/DataTujuan.dart';
import 'package:flutter_application_2/view/barang_masuk/DataTransaksi.dart';
import 'package:flutter_application_2/view/barang_keluar/DataTransaksiBk.dart';
import 'package:flutter_application_2/view/stok/DataStok.dart';
import 'package:flutter_application_2/view/laporan/FormLbk.dart';
import 'package:flutter_application_2/view/laporan/FormLaporan.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:http/http.dart' as http;

class MenuPage extends StatefulWidget {
  final VoidCallback LogOut;
  MenuPage(this.LogOut);
  @override
  State<MenuPage> createState() => _MenuPageState();
}

class _MenuPageState extends State<MenuPage> {
  FocusNode myFocusNode = new FocusNode();
  String? IdUsr, LvlUsr, NamaUsr;
  bool _MDTileExpanded = false;
  bool _TsTileExpanded = false;
  bool _LpTileExpanded = false;
  getPref() async {
    SharedPreferences pref = await SharedPreferences.getInstance();
    setState(() {
      IdUsr = pref.getString("id");
      NamaUsr = pref.getString("nama");
      LvlUsr = pref.getString("level");
    });
  }

  LogOut() {
    setState(() {
      widget.LogOut();
    });
  }

  var loading = false;
  String Stl = "0";
  String Sbm = "0";
  String Sbk = "0";
  final ex = List<CountData>.empty(growable: true);
  _countBR() async {
    setState(() {
      loading = true;
    });
    ex.clear();
    final response = await http.get(Uri.parse(BaseUrl.urlCount));
    final data = jsonDecode(response.body);
    data.forEach((api) {
      final exp = new CountData(api['stok'], api['jm'], api['jk']);
      ex.add(exp);
      setState(() {
        Stl = exp.stok.toString();
        Sbm = exp.jm.toString();
        Sbk = exp.jk.toString();
      });
    });
    setState(() {
      _countBR();
      loading = false;
    });
  }

  @override
  void initState() {
    super.initState();
    getPref();
    _countBR();
  }

  infoOut() {
    AwesomeDialog(
      context: context,
      dialogType: DialogType.warning,
      headerAnimationLoop: true,
      animType: AnimType.bottomSlide,
      title: 'Ready to Leave?',
      reverseBtnOrder: true,
      btnOkText: 'Logout',
      btnOkOnPress: () {
        LogOut();
      },
      btnCancelOnPress: () {},
      desc:
          'Select "Logout" below if you are ready to end your current session.',
    ).show();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        elevation: 0.1,
        backgroundColor: Color.fromARGB(255, 6, 111, 192),
        title: Text('SISTEMATIS'),
      ),
      body: Column(
        children: <Widget>[
          Container(
            margin: EdgeInsets.only(top: 10, left: 20, right: 20),
            child: Card(
              color: Color.fromARGB(255, 250, 248, 246),
              child: ClipPath(
                child: Container(
                  padding: EdgeInsets.all(16),
                  decoration: BoxDecoration(
                    border: Border(
                      left: BorderSide(
                          color: Color.fromARGB(255, 160, 238, 206), width: 5),
                    ),
                  ),
                  child:
                      Column(mainAxisSize: MainAxisSize.min, children: <Widget>[
                    ListTile(
                      title: Text("Total Barang Masuk",
                          style: TextStyle(
                              color: Color.fromARGB(255, 23, 33, 41))),
                      subtitle: Sbm == "null"
                          ? Text("0",
                              style: TextStyle(
                                  color: Color.fromARGB(255, 23, 33, 41),
                                  fontSize: 20,
                                  fontWeight: FontWeight.bold))
                          : Text(Sbm,
                              style: TextStyle(
                                  color: Color.fromARGB(255, 23, 33, 41),
                                  fontSize: 20,
                                  fontWeight: FontWeight.bold)),
                      trailing: FaIcon(FontAwesomeIcons.box, size: 40),
                    ),
                  ]),
                ),
                clipper: ShapeBorderClipper(
                    shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(3))),
              ),
            ),
          ),
          Container(
            margin: EdgeInsets.only(top: 10, left: 20, right: 20),
            child: Card(
              color: const Color.fromARGB(255, 250, 248, 246),
              child: ClipPath(
                child: Container(
                  padding: EdgeInsets.all(16),
                  decoration: BoxDecoration(
                    border: Border(
                      left: BorderSide(
                          color: Color.fromARGB(255, 241, 140, 168), width: 5),
                    ),
                  ),
                  child:
                      Column(mainAxisSize: MainAxisSize.min, children: <Widget>[
                    ListTile(
                      title: Text("Total Barang Keluar",
                          style: TextStyle(
                              color: Color.fromARGB(255, 23, 33, 41))),
                      subtitle: Sbk.toString() == "null"
                          ? Text("0",
                              style: TextStyle(
                                  color: Color.fromARGB(255, 23, 33, 41),
                                  fontSize: 20,
                                  fontWeight: FontWeight.bold))
                          : Text(Sbk,
                              style: TextStyle(
                                  color: Color.fromARGB(255, 23, 33, 41),
                                  fontSize: 20,
                                  fontWeight: FontWeight.bold)),
                      trailing: FaIcon(
                        FontAwesomeIcons.boxOpen,
                        size: 40,
                      ),
                    ),
                  ]),
                ),
                clipper: ShapeBorderClipper(
                    shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(3))),
              ),
            ),
          ),
          Container(
            margin: EdgeInsets.only(top: 10, left: 20, right: 20),
            child: Card(
              color: const Color.fromARGB(255, 250, 248, 246),
              child: ClipPath(
                child: Container(
                  padding: EdgeInsets.all(16),
                  decoration: BoxDecoration(
                    border: Border(
                      left: BorderSide(
                          color: Color.fromARGB(255, 241, 140, 168), width: 5),
                    ),
                  ),
                  child:
                      Column(mainAxisSize: MainAxisSize.min, children: <Widget>[
                    ListTile(
                      title: Text("Total Stok Barang",
                          style: TextStyle(
                              color: Color.fromARGB(255, 23, 33, 41))),
                      subtitle: Stl.toString() == "null"
                          ? Text("0",
                              style: TextStyle(
                                  color: Color.fromARGB(255, 23, 33, 41),
                                  fontSize: 20,
                                  fontWeight: FontWeight.bold))
                          : Text(Stl,
                              style: TextStyle(
                                  color: Color.fromARGB(255, 23, 33, 41),
                                  fontSize: 20,
                                  fontWeight: FontWeight.bold)),
                      trailing: FaIcon(FontAwesomeIcons.boxesStacked, size: 40),
                    ),
                  ]),
                ),
                clipper: ShapeBorderClipper(
                    shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(3))),
              ),
            ),
          ),
        ],
      ),
      drawer: Drawer(
        child: ListView(
          padding: EdgeInsets.zero,
          children: [
            UserAccountsDrawerHeader(
              accountName: Text(NamaUsr.toString()),
              accountEmail:
                  LvlUsr.toString() == "1" ? Text("Admin") : Text("Karyawan"),
              currentAccountPicture: new CircleAvatar(
                backgroundImage: AssetImage("assets/Sistematis.png"),
              ),
              decoration: BoxDecoration(
                color: Color.fromARGB(255, 6, 111, 192),
              ),
            ),
            ListTile(
                leading: Icon(Icons.person),
                title: Text("Profil"),
                onTap: () {}),
            Divider(height: 25, thickness: 1),
            Theme(
              data: ThemeData().copyWith(dividerColor: Colors.transparent),
              child: ExpansionTile(
                leading: FaIcon(
                  FontAwesomeIcons.database,
                  color: myFocusNode.hasFocus
                      ? Colors.blue
                      : Color.fromARGB(255, 119, 120, 121),
                ),
                title: Text(
                  "Master Data",
                  style: TextStyle(
                      color: myFocusNode.hasFocus
                          ? Colors.blue
                          : Color.fromARGB(255, 51, 53, 54)),
                ),
                trailing: FaIcon(
                    _MDTileExpanded
                        ? FontAwesomeIcons.chevronDown
                        : FontAwesomeIcons.chevronRight,
                    size: 15,
                    color: myFocusNode.hasFocus
                        ? Colors.blue
                        : Color.fromARGB(255, 119, 120, 121)),
                children: [
                  ListTile(
                    leading: Text(""),
                    title: Text("Kategori Stok"),
                    onTap: () {
                      Navigator.push(
                          context,
                          MaterialPageRoute(
                              builder: (context) => new DataJenis()));
                    },
                  ),
                  // ListTile(
                  //   leading: Text(""),
                  //   title: Text("Data Brand"),
                  //   onTap: () {},
                  // ),
                  ListTile(
                    leading: Text(""),
                    title: Text("Inventory Stok"),
                    onTap: () {
                      Navigator.push(
                          context,
                          MaterialPageRoute(
                              builder: (context) => new DataBarang()));
                    },
                  ),
                  ListTile(
                    leading: Text(""),
                    title: Text("Data Tujuan"),
                    onTap: () {
                      Navigator.push(
                          context,
                          MaterialPageRoute(
                              builder: (context) => new DataTujuan()));
                    },
                  ),
                  if (LvlUsr == "1") ...[
                    ListTile(
                      leading: Text(""),
                      title: Text("Data Admin"),
                      onTap: () {
                        Navigator.push(
                            context,
                            MaterialPageRoute(
                                builder: (context) => new DataAdmin()));
                      },
                    ),
                  ],
                ],
                onExpansionChanged: (bool expanded) {
                  setState(() => _MDTileExpanded = expanded);
                },
              ),
            ),
            Divider(height: 25, thickness: 1),
            Theme(
              data: ThemeData().copyWith(dividerColor: Colors.transparent),
              child: ExpansionTile(
                  leading: FaIcon(
                    FontAwesomeIcons.exchange,
                    color: myFocusNode.hasFocus
                        ? Colors.blue
                        : Color.fromARGB(255, 119, 120, 121),
                  ),
                  title: Text(
                    "Transaksi",
                    style: TextStyle(
                        color: myFocusNode.hasFocus
                            ? Colors.blue
                            : Color.fromARGB(255, 51, 53, 54)),
                  ),
                  trailing: FaIcon(
                      _TsTileExpanded
                          ? FontAwesomeIcons.chevronDown
                          : FontAwesomeIcons.chevronRight,
                      size: 15,
                      color: myFocusNode.hasFocus
                          ? Colors.blue
                          : Color.fromARGB(255, 119, 120, 121)),
                  children: [
                    ListTile(
                      leading: Text(""),
                      title: Text("Barang Masuk"),
                      onTap: () {
                        Navigator.push(
                            context,
                            MaterialPageRoute(
                                builder: (context) => new DataTransaksi()));
                      },
                    ),
                    ListTile(
                      leading: Text(""),
                      title: Text("Barang Keluar"),
                      onTap: () {
                        Navigator.push(
                            context,
                            MaterialPageRoute(
                                builder: (context) => new DataTransaksiBk()));
                      },
                    ),
                  ],
                  onExpansionChanged: (bool expanded) {
                    setState(() => _TsTileExpanded = expanded);
                  }),
            ),
            Divider(height: 25, thickness: 1),
            Theme(
              data: ThemeData().copyWith(dividerColor: Colors.transparent),
              child: ExpansionTile(
                leading: FaIcon(
                  FontAwesomeIcons.clipboardList,
                  color: myFocusNode.hasFocus
                      ? Colors.blue
                      : Color.fromARGB(255, 119, 120, 121),
                ),
                title: Text(
                  "Laporan",
                  style: TextStyle(
                      color: myFocusNode.hasFocus
                          ? Colors.blue
                          : Color.fromARGB(255, 51, 53, 54)),
                ),
                trailing: FaIcon(
                    _LpTileExpanded
                        ? FontAwesomeIcons.chevronDown
                        : FontAwesomeIcons.chevronRight,
                    size: 15,
                    color: myFocusNode.hasFocus
                        ? Colors.blue
                        : Color.fromARGB(255, 119, 120, 121)),
                children: [
                  ListTile(
                    leading: Text(""),
                    title: Text("Data Stok"),
                    onTap: () {
                      Navigator.push(
                          context,
                          MaterialPageRoute(
                              builder: (context) => new DataStok()));
                    },
                  ),
                  ListTile(
                    leading: Text(""),
                    title: Text("Laporan Barang Masuk"),
                    onTap: () {
                      Navigator.push(
                          context,
                          MaterialPageRoute(
                              builder: (context) => new FormLaporan()));
                    },
                  ),
                  ListTile(
                    leading: Text(""),
                    title: Text("Laporan Barang Keluar"),
                    onTap: () {
                      Navigator.push(
                          context,
                          MaterialPageRoute(
                              builder: (context) => new FormLbk()));
                    },
                  ),
                ],
                onExpansionChanged: (bool expanded) {
                  setState(() => _LpTileExpanded = expanded);
                },
              ),
            ),
            Divider(height: 25, thickness: 1),
            ListTile(
              leading: Icon(Icons.logout),
              title: Text("Logout"),
              onTap: () => infoOut(),
            ),
          ],
        ),
      ),
      drawerEnableOpenDragGesture: false,
    );
  }
}
