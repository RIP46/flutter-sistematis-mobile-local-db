import 'package:flutter/material.dart';
import 'package:flutter_application_2/model/api.dart';
import 'package:flutter_application_2/model/JenisModel.dart';
import 'package:http/http.dart' as http;
import 'package:intl/intl.dart';
import 'package:flutter/services.dart';
import 'package:async/async.dart';
import 'dart:convert';

class EditJenis extends StatefulWidget {
  final VoidCallback reload;
  final JenisModel model;
  EditJenis(this.model, this.reload);
  @override
  State<EditJenis> createState() => _EditJenisState();
}

class _EditJenisState extends State<EditJenis> {
  FocusNode myFocusNode = new FocusNode();
  String? id_jenis, jenis;
  final _key = new GlobalKey<FormState>();
  TextEditingController? txtidJenis, txtJenis;
  setup() async {
    txtJenis = TextEditingController(text: widget.model.nama_jenis);
    id_jenis = widget.model.id_jenis;
  }

  check() {
    final form = _key.currentState;
    if ((form as dynamic).validate()) {
      (form as dynamic).save();
      ProsUp();
    }
  }

  ProsUp() async {
    try {
      final respon = await http.post(Uri.parse(BaseUrl.urlEditJenis.toString()),
          body: {"id_jenis": id_jenis, "jenis": jenis});
      final data = jsonDecode(respon.body);
      print(data);
      int code = data['success'];
      String pesan = data['message'];
      print(data);
      if (code == 1) {
        setState(() {
          widget.reload();
          Navigator.pop(context);
        });
      } else {
        print(pesan);
      }
    } catch (e) {
      debugPrint(e.toString());
    }
  }

  @override
  void initState() {
    super.initState();
    setup();
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
                "Edit Jenis Barang",
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
            TextFormField(
              controller: txtJenis,
              validator: (e) {
                if (e!.isEmpty) {
                  return "Silahkan isi Jenis";
                } else {
                  return null;
                }
              },
              onSaved: (e) => jenis = e,
              decoration: InputDecoration(
                labelText: 'Jenis Barang',
                labelStyle: TextStyle(
                    color: myFocusNode.hasFocus
                        ? Colors.blue
                        : Color.fromARGB(255, 32, 54, 70)),
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(10),
                ),
                focusedBorder: OutlineInputBorder(
                  borderSide:
                      const BorderSide(color: Color.fromARGB(255, 32, 54, 70)),
                ),
              ),
            ),
            SizedBox(
              height: 25,
            ),
            MaterialButton(
              color: Color.fromARGB(255, 144, 168, 9),
              onPressed: () {
                check();
              },
              child: Text(
                "Edit",
                style: TextStyle(color: Colors.white),
              ),
              shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(10)),
            )
          ],
        ),
      ),
    );
  }
}
