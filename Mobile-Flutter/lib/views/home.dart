import 'package:flutter/material.dart';
import 'package:matchingfundbanksampah/components/bottom_navigation.dart';

class HomePage extends StatefulWidget {
  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  int _selectedIndex = 0;

  void _onTabTapped(int index) {
    setState(() {
      _selectedIndex = index;
      if (index == 0) {
        Navigator.pushNamed(context, '/home');
      } else if (index == 1) {
        Navigator.pushNamed(context, '/history');
      }
      else if (index == 2) {
        Navigator.pushNamed(context, '/schedule');
      }
      else if (index == 3) {
        Navigator.pushNamed(context, '/exchange');
      }
      else if (index == 4) {
        Navigator.pushNamed(context, '/login');
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    double screenWidth = MediaQuery.of(context).size.width;

    return Scaffold(
      bottomNavigationBar: BottomNavigationWidget(
        selectedIndex: _selectedIndex,
        onTabTapped: _onTabTapped,
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: EdgeInsets.symmetric(horizontal: 2.0, vertical: 20.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // User icon and text
              SizedBox(height: 20.0),

              // Center everything vertically
               Column(
                  children: [
                    Align(
                    alignment: Alignment(-0.9, 0.0),// Ini akan menggeser elemen ke kanan
                      child: Row(
                        mainAxisSize: MainAxisSize.min,
                        children: [
                          Icon(
                            Icons.account_circle_rounded,
                            size: 60,
                            color: Colors.black,
                          ),
                          SizedBox(width: 10), // Spasi antara ikon dan teks
                          Row(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              // "Selamat datang" text
                              Text(
                                'Selamat datang,',
                                style: TextStyle(
                                  fontSize: 16,
                                  fontWeight: FontWeight.normal,
                                  color: Colors.black,
                                ),
                              ),
                              // "Jhoe Doe" text
                              Text(
                                'Jhoe Doe',
                                style: TextStyle(
                                  fontSize: 16,
                                  fontWeight: FontWeight.bold,
                                  color: Colors.black,
                                ),
                              ),
                            ],
                          ),
                        ],
                      ),
                    ),
                    // Colored box with BoxDecoration
                    SizedBox(height: 20,),
                    Container(
                      width: screenWidth - 32,
                      height: 120,
                      decoration: BoxDecoration(
                        color: Colors.blue.withOpacity(0.2),
                        borderRadius: BorderRadius.circular(20),
                        border: Border.all(
                          color: Colors.black.withOpacity(0.5),
                          width: 2.0,
                        ),
                      ),
                      child: Padding(
                        padding: const EdgeInsets.all(8.0),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: <Widget>[
                            Align(
                              alignment: Alignment.centerLeft,
                              child: Text(
                                'Rp.20.000,00',
                                style: TextStyle(
                                  fontSize: 16,
                                  color: Colors.black,
                                ),
                              ),
                            ),
                            SizedBox(height: 8), // Spacing between text
                            Align(
                              alignment: Alignment.centerLeft,
                              child: Row(
                                children: <Widget>[
                                  Text(
                                    '100-9200-0200-000',
                                    style: TextStyle(
                                      fontSize: 16,
                                      fontWeight: FontWeight.normal,
                                      color: Colors.black,
                                    ),
                                  ),
                                  SizedBox(width: 8), // Spacing between text and icon
                                  Icon(
                                    Icons.copy, // Change this to the appropriate icon
                                    color: Colors.black,
                                  ),
                                ],
                              ),
                            ),
                            SizedBox(height: 8), // Spacing between text
                            Align(
                              alignment: Alignment.centerLeft,
                              child: Text(
                                'Kode Nasabah',
                                style: TextStyle(
                                  fontSize: 16,
                                  fontWeight: FontWeight.normal,
                                  color: Colors.black,
                                ),
                              ),
                            ),
                          ],
                        ),
                      ),
                    ),
                    // Recent Transactions
                    SizedBox(height: 15,),
                    Padding(
                      padding: const EdgeInsets.all(18.0),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: <Widget>[
                          Align(
                            alignment: Alignment.centerLeft,
                            child: Text(
                              'Transaksi Terakhir',
                              style: TextStyle(
                                fontSize: 18,
                                fontWeight: FontWeight.w500,
                                color: Colors.black,
                              ),
                            ),
                          ),
                        ],
                      ),
                    ),
                    SizedBox(height: 0,),
                    Padding(
                      padding: const EdgeInsets.all(18.0),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: <Widget>[
                          Align(
                            alignment: Alignment.centerLeft,
                            child: Text(
                              '20 September 2023',
                              style: TextStyle(
                                fontSize: 12,
                                fontWeight: FontWeight.normal,
                                color: Colors.black38,
                              ),
                            ),
                          ),
                          SizedBox(height: 8),
                          Row(
                            children: <Widget>[
                              Text(
                                'Setoran Sampah',
                                style: TextStyle(
                                  fontSize: 14,
                                  fontWeight: FontWeight.w500,
                                  color: Colors.black,
                                ),
                              ),
                              SizedBox(
                                width: MediaQuery.of(context).size.width * 0.45, // Misalnya, 40% dari lebar layar
                              ), // Spacing between text and amount
                              Text(
                                'Rp.20.000',
                                style: TextStyle(
                                  fontSize: 14,
                                  fontWeight: FontWeight.w500,
                                  color: Colors.green,
                                ),
                              ),
                            ],
                          ),
                          SizedBox(height: 4), // Spacing between text
                          Align(
                            alignment: Alignment.centerLeft,
                            child: Text(
                              'Setoran sampah di Bank Sampah Induk',
                              style: TextStyle(
                                fontSize: 12,
                                fontWeight: FontWeight.normal,
                                color: Colors.black38,
                              ),
                            ),
                          ),
                        ],
                      ),
                    ),
                    // Transaction 2
                    Padding(
                      padding: const EdgeInsets.all(18.0),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: <Widget>[
                          Align(
                            alignment: Alignment.centerLeft,
                            child: Text(
                              '20 September 2023',
                              style: TextStyle(
                                fontSize: 12,
                                fontWeight: FontWeight.normal,
                                color: Colors.black38,
                              ),
                            ),
                          ),
                          SizedBox(height: 8),
                          Row(
                            children: <Widget>[
                              Text(
                                'Pencairan Saldo ',
                                style: TextStyle(
                                  fontSize: 14,
                                  fontWeight: FontWeight.w500,
                                  color: Colors.black,
                                ),
                              ),
                              SizedBox(
                                width: MediaQuery.of(context).size.width * 0.45, // Misalnya, 40% dari lebar layar
                              ), // Spacing between text and amount
                              Text(
                                'Rp.20.000',
                                style: TextStyle(
                                  fontSize: 14,
                                  fontWeight: FontWeight.w500,
                                  color: Colors.green,
                                ),
                              ),
                            ],
                          ),
                          SizedBox(height: 4), // Spacing between text
                          Align(
                            alignment: Alignment.centerLeft,
                            child: Text(
                              'Transfer ke 9898278871',
                              style: TextStyle(
                                fontSize: 12,
                                fontWeight: FontWeight.normal,
                                color: Colors.black38,
                              ),
                            ),
                          ),
                        ],
                      ),
                    ),
                    SizedBox(height: 0,),
                    Padding(
                      padding: const EdgeInsets.all(18.0),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: <Widget>[
                          Align(
                            alignment: Alignment.centerLeft,
                            child: Text(
                              '20 September 2023',
                              style: TextStyle(
                                fontSize: 12,
                                fontWeight: FontWeight.normal,
                                color: Colors.black38,
                              ),
                            ),
                          ),
                          SizedBox(height: 8),
                          Row(
                            children: <Widget>[
                              Text(
                                'Setoran Sampah',
                                style: TextStyle(
                                  fontSize: 14,
                                  fontWeight: FontWeight.w500,
                                  color: Colors.black,
                                ),
                              ),
                              SizedBox(
                                width: MediaQuery
                                    .of(context)
                                    .size
                                    .width *
                                    0.45, // Misalnya, 40% dari lebar layar
                              ), // Spacing between text and amount
                              Text(
                                'Rp.20.000',
                                style: TextStyle(
                                  fontSize: 14,
                                  fontWeight: FontWeight.w500,
                                  color: Colors.green,
                                ),
                              ),
                            ],
                          ),
                          SizedBox(height: 4), // Spacing between text
                          Align(
                            alignment: Alignment.centerLeft,
                            child: Text(
                              'Setoran sampah di Bank Sampah Induk',
                              style: TextStyle(
                                fontSize: 12,
                                fontWeight: FontWeight.normal,
                                color: Colors.black38,
                              ),
                            ),
                          ),
                        ],
                      ),
                    ),
                    // Transaction 2
                    Padding(
                      padding: const EdgeInsets.all(18.0),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: <Widget>[
                          Align(
                            alignment: Alignment.centerLeft,
                            child: Text(
                              '20 September 2023',
                              style: TextStyle(
                                fontSize: 12,
                                fontWeight: FontWeight.normal,
                                color: Colors.black38,
                              ),
                            ),
                          ),
                          SizedBox(height: 8),
                          Row(
                            children: <Widget>[
                              Text(
                                'Pencairan Saldo ',
                                style: TextStyle(
                                  fontSize: 14,
                                  fontWeight: FontWeight.w500,
                                  color: Colors.black,
                                ),
                              ),
                              SizedBox(
                                width: MediaQuery
                                    .of(context)
                                    .size
                                    .width *
                                    0.45, // Misalnya, 40% dari lebar layar
                              ), // Spacing between text and amount
                              Text(
                                'Rp.20.000',
                                style: TextStyle(
                                  fontSize: 14,
                                  fontWeight: FontWeight.w500,
                                  color: Colors.green,
                                ),
                              ),
                            ],
                          ),
                          SizedBox(height: 4), // Spacing between text
                          Align(
                            alignment: Alignment.centerLeft,
                            child: Text(
                              'Transfer ke 9898278871',
                              style: TextStyle(
                                fontSize: 12,
                                fontWeight: FontWeight.normal,
                                color: Colors.black38,
                              ),
                            ),
                          ),
                        ],
                      ),
                    ),
                    SizedBox(height: 0,),
                    Padding(
                      padding: const EdgeInsets.all(18.0),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: <Widget>[
                          Align(
                            alignment: Alignment.centerLeft,
                            child: Text(
                              '20 September 2023',
                              style: TextStyle(
                                fontSize: 12,
                                fontWeight: FontWeight.normal,
                                color: Colors.black38,
                              ),
                            ),
                          ),
                          SizedBox(height: 8),
                          Row(
                            children: <Widget>[
                              Text(
                                'Setoran Sampah',
                                style: TextStyle(
                                  fontSize: 14,
                                  fontWeight: FontWeight.w500,
                                  color: Colors.black,
                                ),
                              ),
                              SizedBox(
                                width: MediaQuery
                                    .of(context)
                                    .size
                                    .width *
                                    0.45, // Misalnya, 40% dari lebar layar
                              ), // Spacing between text and amount
                              Text(
                                'Rp.20.000',
                                style: TextStyle(
                                  fontSize: 14,
                                  fontWeight: FontWeight.w500,
                                  color: Colors.green,
                                ),
                              ),
                            ],
                          ),
                          SizedBox(height: 4), // Spacing between text
                          Align(
                            alignment: Alignment.centerLeft,
                            child: Text(
                              'Setoran sampah di Bank Sampah Induk',
                              style: TextStyle(
                                fontSize: 12,
                                fontWeight: FontWeight.normal,
                                color: Colors.black38,
                              ),
                            ),
                          ),
                        ],
                      ),
                    ),
                    // Transaction 2
                    Padding(
                      padding: const EdgeInsets.all(18.0),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: <Widget>[
                          Align(
                            alignment: Alignment.centerLeft,
                            child: Text(
                              '20 September 2023',
                              style: TextStyle(
                                fontSize: 12,
                                fontWeight: FontWeight.normal,
                                color: Colors.black38,
                              ),
                            ),
                          ),
                          SizedBox(height: 8),
                          Row(
                            children: <Widget>[
                              Text(
                                'Pencairan Saldo ',
                                style: TextStyle(
                                  fontSize: 14,
                                  fontWeight: FontWeight.w500,
                                  color: Colors.black,
                                ),
                              ),
                              SizedBox(
                                width: MediaQuery
                                    .of(context)
                                    .size
                                    .width *
                                    0.45, // Misalnya, 40% dari lebar layar
                              ), // Spacing between text and amount
                              Text(
                                'Rp.20.000',
                                style: TextStyle(
                                  fontSize: 14,
                                  fontWeight: FontWeight.w500,
                                  color: Colors.green,
                                ),
                              ),
                            ],
                          ),
                          SizedBox(height: 4), // Spacing between text
                          Align(
                            alignment: Alignment.centerLeft,
                            child: Text(
                              'Transfer ke 9898278871',
                              style: TextStyle(
                                fontSize: 12,
                                fontWeight: FontWeight.normal,
                                color: Colors.black38,
                              ),
                            ),
                          ),
                        ],
                      ),
                    ),
                  ],
                ),

            ],
          ),
        ),
      ),
    );
  }
}