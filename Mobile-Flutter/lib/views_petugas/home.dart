import 'dart:ffi';

import 'package:matchingfundbanksampah/components/bottom_navigation.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class HomePage extends StatefulWidget {
  const HomePage({Key? key}) : super(key: key);

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  int _selectedIndex = 0;

  void _onTabTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        bottomNavigationBar: BottomNavigationWidget(
          selectedIndex: _selectedIndex,
          onTabTapped: _onTabTapped,
        ),
        backgroundColor: Colors.white,
        body: ListView(
          children: [
            _builItem(),
          ],
        )
    );
  }

  Widget _buildTransactionItem(String? dateTime, String? title, double kilo, String? desc, String? name, String? status, Color color) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          dateTime!,
          style: TextStyle(
            color: Colors.grey,
            fontSize: 15,
          ),
        ),
        Row(
          children: [
            Text(
              title!,
              style: TextStyle(
                color: Colors.black,
                fontSize: 17,
              ),
            ),
            Expanded(child: Container()),
            Text(
              "+$kilo",
              style: TextStyle(
                fontSize: 17,
                color: Colors.green,
              ),
            )
          ],
        ),
        Text(
          desc!,
          style: TextStyle(
            color: Colors.grey,
            fontSize: 15,
          ),
        ),
        Row(
          children: [
            Text(
              name!,
              style: TextStyle(
                color: Colors.grey,
                fontSize: 15,
              ),
            ),
            Expanded(child: Container(),),
            Text(
              status!,
              style: TextStyle(
                color: color,
                fontSize: 15,
              ),
            ),
          ],
        ),
      ],
    );
  }
  Widget _builItem() {
    return Container(
      padding: const EdgeInsets.only(top: 10, left: 10, right: 10),
      child: Column(
        children: [
           Row(
            children: [
              Icon(
                Icons.account_circle,
                size: 70,
                color: Colors.black,
              ),
              Text(
                "Selamat Datang, ",
                style: TextStyle(
                    fontSize: 17,
                    color: Colors.black
                ),
              ),
              Text(
                "William State",
                style: TextStyle(
                    fontSize: 17,
                    color: Colors.black,
                    fontWeight: FontWeight.bold
                ),
              )
            ],
          ),
          const SizedBox(height: 20,),
          Container(
            width: MediaQuery.of(context).size.width,
            height: 110,
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: const BorderRadius.all(Radius.circular(20)),
              border: Border.all(
                  color: Colors.black,
                  width: 1.0
              ),
            ),
            child: Container(
              padding: const EdgeInsets.only(left: 20, top: 10),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text("Jumlah Setoran Sampah Hari Ini",
                    style: TextStyle(
                      fontSize: 17,
                      color: Colors.black,
                    ),
                  ),
                  SizedBox(height: 10,),
                  Text("68,89 Kg",
                    style: TextStyle(
                        fontSize: 17,
                        color: Colors.black,
                        fontWeight: FontWeight.bold
                    ),
                  ),
                  SizedBox(height: 10,),
                  Text("Kamis, 10 Agustus 2023",
                    style: TextStyle(
                      fontSize: 17,
                      color: Colors.black,
                    ),
                  ),
                ],
              ),
            ),
          ),
          const SizedBox(height: 20,),
          const Align(
            alignment: Alignment.centerLeft,
            child: Text(
              "Transaksi Terakhir",style:
            TextStyle(
              fontSize: 17,
              color: Colors.black,
            ),
            ),
          ),
          _buildTransactionItem("20 September 2023", "Setoran Sampah", 0.98, "Setoran Sampah Dari Nasahab", "Angelina Kim", "Belum Approve", Colors.red),
          const SizedBox(height: 10,),
          _buildTransactionItem("21 September 2023", "Setoran Sampah", 1.2, "Setoran Sampah Dari Nasahab", "James Bond", "Sudah Approve", Colors.blue),
        ],
      ),
    );
  }
}