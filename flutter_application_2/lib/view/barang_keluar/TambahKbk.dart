import 'package:flutter/material.dart';
import 'package:flutter/src/foundation/key.dart';
import 'package:flutter/src/widgets/framework.dart';
import 'package:http/http.dart' as http;
import 'package:intl/intl.dart';
import 'package:flutter/services.dart';
import 'package:async/async.dart';
import 'package:flutter_application_2/model/BarangModel.dart';
import 'package:flutter_application_2/model/api.dart';
import 'package:flutter_application_2/view/barang_keluar/KeranjangBK.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';
import 'package:awesome_dialog/awesome_dialog.dart';

class TambahKbk extends StatefulWidget {
  @override
  State<TambahKbk> createState() => _TambahKbkState();
}

class _TambahKbkState extends State<TambahKbk> {
  FocusNode JmFocusNode = new FocusNode();
  String? IdAdm, Barang, Jumlah;
  getPref() async {
    SharedPreferences pref = await SharedPreferences.getInstance();
    setState(() {
      IdAdm = pref.getString("id");
    });
  }

  final _key = new GlobalKey<FormState>();
  BarangModel? _currentBR;
  final String? inkBR = BaseUrl.urlDataBr;
  Future<List<BarangModel>> _fetchBR() async {
    var response = await http.get(Uri.parse(inkBR.toString()));
    print('hasil: ' + response.statusCode.toString());
    if (response.statusCode == 200) {
      final items = json.decode(response.body).cast<Map<String, dynamic>>();
      List<BarangModel> listOfBR = items.map<BarangModel>((json) {
        return BarangModel.fromJson(json);
      }).toList();
      return listOfBR;
    } else {
      throw Exception('gagal');
    }
  }

  dialogSukses(String pesan) {
    AwesomeDialog(
      context: context,
      dismissOnTouchOutside: false,
      animType: AnimType.leftSlide,
      headerAnimationLoop: false,
      dialogType: DialogType.success,
      showCloseIcon: true,
      title: 'Succes',
      desc: pesan,
      btnOkOnPress: () {
        Navigator.pop(context);
        Navigator.push(context,
            MaterialPageRoute(builder: (context) => new KeranjangBK()));
      },
      btnOkIcon: Icons.check_circle,
      onDismissCallback: (type) {
        debugPrint('Dialog Dissmiss from callback $type');
      },
    ).show();
  }

  dialogGagal(String pesan) {
    AwesomeDialog(
      dismissOnTouchOutside: false,
      context: context,
      dialogType: DialogType.error,
      animType: AnimType.rightSlide,
      headerAnimationLoop: false,
      title: 'ERROR',
      desc: pesan,
      btnOkOnPress: () {},
      btnOkIcon: Icons.cancel,
      btnOkColor: Colors.red,
    ).show();
  }

  check() {
    final form = _key.currentState;
    if ((form as dynamic).validate()) {
      (form as dynamic).save();
      Simpan();
    }
  }

  Simpan() async {
    try {
      final response = await http.post(
          Uri.parse(BaseUrl.urlInputCBK.toString()),
          body: {"barang": Barang, "jumlah": Jumlah, "id": IdAdm});
      final data = jsonDecode(response.body);
      print(data);
      int code = data['success'];
      String pesan = data['message'];
      print(data);
      if (code == 1) {
        setState(() {
          dialogSukses(pesan);
        });
      } else {
        dialogGagal(pesan);
      }
    } catch (e) {
      debugPrint(e.toString());
    }
  }

  @override
  void initState() {
    super.initState();
    getPref();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        backgroundColor: Color.fromRGBO(244, 244, 244, 1),
        appBar: AppBar(
          automaticallyImplyLeading: false,
          backgroundColor: Color.fromARGB(255, 6, 111, 192),
          title: Row(
            mainAxisAlignment: MainAxisAlignment.start,
            children: <Widget>[
              Container(
                child: Text(
                  "Tambah Barang Keluar",
                  style: TextStyle(color: Colors.white, fontSize: 20.0),
                ),
              )
            ],
          ),
        ),
        body: Form(
          key: _key,
          child: ListView(
            padding: EdgeInsets.all(16.0),
            children: <Widget>[
              FutureBuilder<List<BarangModel>>(
                future: _fetchBR(),
                builder: (BuildContext context,
                    AsyncSnapshot<List<BarangModel>> snapshot) {
                  if (!snapshot.hasData) return CircularProgressIndicator();
                  return Container(
                      padding: EdgeInsets.symmetric(horizontal: 10.0),
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(10.0),
                        border: Border.all(
                            style: BorderStyle.solid,
                            color: Color.fromARGB(255, 32, 54, 70),
                            width: 0.80),
                      ),
                      child: DropdownButtonHideUnderline(
                          child: DropdownButton(
                        items: snapshot.data!
                            .map((listBR) => DropdownMenuItem(
                                  child: Text(listBR.nama_barang.toString() +
                                      "(" +
                                      listBR.nama_brand.toString() +
                                      ")"),
                                  value: listBR,
                                ))
                            .toList(),
                        onChanged: (BarangModel? value) {
                          setState(() {
                            _currentBR = value;
                            Barang = _currentBR!.id_barang;
                          });
                        },
                        isExpanded: true,
                        hint: Text(Barang == null
                            ? "Pilih Barang"
                            : _currentBR!.nama_barang.toString() +
                                " ( " +
                                _currentBR!.nama_brand.toString() +
                                " )"),
                      )));
                },
              ),
              SizedBox(
                height: 20.0,
              ),
              TextFormField(
                validator: (e) {
                  if ((e as dynamic).isEmpty) {
                    return "Silahkan isi Jumlah";
                  }
                },
                onSaved: (e) => Jumlah = e,
                focusNode: JmFocusNode,
                decoration: InputDecoration(
                  labelText: 'Jumlah Barang',
                  labelStyle: TextStyle(
                      color: JmFocusNode.hasFocus
                          ? Colors.blue
                          : Color.fromARGB(255, 32, 54, 70)),
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10),
                  ),
                  focusedBorder: OutlineInputBorder(
                    borderSide: const BorderSide(
                        color: Color.fromARGB(255, 32, 54, 70)),
                  ),
                ),
              ),
              SizedBox(
                height: 25,
              ),
              MaterialButton(
                color: Color.fromARGB(255, 23, 122, 84),
                onPressed: () {
                  check();
                },
                child: Text(
                  "Simpan",
                  style: TextStyle(color: Colors.white),
                ),
                shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10)),
              )
            ],
          ),
        ));
  }
}
