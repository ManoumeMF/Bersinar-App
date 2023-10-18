import 'package:matchingfundbanksampah/components/bottom_navigation.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class HistoryPage extends StatefulWidget {
  const HistoryPage({Key? key}) : super(key: key);

  @override
  State<HistoryPage> createState() => _HistoryPageState();
}

class _HistoryPageState extends State<HistoryPage> {
  int _selectedIndex = 1;
  void _onTabTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Riwayat Setoran Sampah", style:
        TextStyle(
            color: Colors.white,
            fontSize: 17,
            fontWeight: FontWeight.bold
        ),
        ),
        backgroundColor: Colors.green,
        centerTitle: true,
        leading: GestureDetector(
          child: const Icon(Icons.arrow_back_ios, color: Colors.white,),
          onTap: () {},
        ),
        actions: const [
          Icon(Icons.home, color: Colors.yellow,),
          SizedBox(width: 20,)
        ],
      ),
      bottomNavigationBar: BottomNavigationWidget(
        selectedIndex: _selectedIndex,
        onTabTapped: _onTabTapped,
      ),
      backgroundColor: Colors.white,
      body: ListView(
        children: [
          _builItem(),
        ],
      ),
    );
  }

  Widget _buildHistoryTransactionItem(String? dateTime, String? title, double kilo, String? desc, String? name, String? status, Color color) {
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
          const Align(
            alignment: Alignment.centerLeft,
            child: Text(
              "Transaksi",style:
            TextStyle(
              fontSize: 17,
              color: Colors.black,
              fontWeight: FontWeight.bold,
            ),
            ),
          ),
          const SizedBox(height: 20,),
          // Masih secara manual //
          Row(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text("Januari | ", style:
              TextStyle(
                fontSize: 17,
                color: Colors.black,
              ),
              ),
              Text("Februari | ", style:
              TextStyle(
                fontSize: 17,
                color: Colors.black,
              ),
              ),
              Text("Maret", style:
              TextStyle(
                fontSize: 17,
                color: Colors.black,
              ),
              ),
            ],
          ),
          SizedBox(height: 20,),
          _buildHistoryTransactionItem("20 September 2023", "Setoran Sampah", 0.98, "Setoran Sampah Dari Nasahab", "Angelina Kim", "Belum Approve", Colors.red),
          const SizedBox(height: 10,),
          _buildHistoryTransactionItem("21 September 2023", "Setoran Sampah", 1.2, "Setoran Sampah Dari Nasahab", "James Bond", "Sudah Approve", Colors.blue),
          const SizedBox(height: 10,),
          _buildHistoryTransactionItem("20 September 2023", "Setoran Sampah", 0.98, "Setoran Sampah Dari Nasahab", "Angelina Kim", "Belum Approve", Colors.red),
          const SizedBox(height: 10,),
          _buildHistoryTransactionItem("21 September 2023", "Setoran Sampah", 1.2, "Setoran Sampah Dari Nasahab", "James Bond", "Sudah Approve", Colors.blue),
          const SizedBox(height: 10,),
          _buildHistoryTransactionItem("20 September 2023", "Setoran Sampah", 0.98, "Setoran Sampah Dari Nasahab", "Angelina Kim", "Belum Approve", Colors.red),
          const SizedBox(height: 10,),
          _buildHistoryTransactionItem("21 September 2023", "Setoran Sampah", 1.2, "Setoran Sampah Dari Nasahab", "James Bond", "Sudah Approve", Colors.blue),
        ],
      ),
    );
  }
}