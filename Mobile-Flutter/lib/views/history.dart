import 'package:flutter/material.dart';
import 'package:matchingfundbanksampah/components/bottom_navigation.dart';


class HistoryPage extends StatefulWidget {
  @override
  _HistoryPageState createState() => _HistoryPageState();
}

class _HistoryPageState extends State<HistoryPage> {
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
    double screenWidth = MediaQuery
        .of(context)
        .size
        .width;

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
                  // Colored box with BoxDecoration
                  SizedBox(height: 20,),
                  Container(
                    width: screenWidth - 32,
                    height: 120,
                    decoration: BoxDecoration(
                      color: Colors.green.withOpacity(1),
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
                            alignment: Alignment.center,
                            child: Text(
                              'Jhoe Doe',
                              style: TextStyle(
                                fontSize: 20,
                                color: Colors.white,
                                fontWeight: FontWeight.w600
                              ),
                            ),
                          ),
                          SizedBox(height: 8), // Spacing between text
                          Align(
                            alignment: Alignment.center,
                            child: Row(
                              mainAxisAlignment: MainAxisAlignment.center, // Mengatur widget ke tengah horizontal
                              children: <Widget>[
                                Text(
                                  '100-9200-0200-000',
                                  style: TextStyle(
                                    fontSize: 16,
                                    fontWeight: FontWeight.normal,
                                    color: Colors.white,
                                  ),
                                ),
                                SizedBox(width: 8), // Spacing between text and icon
                                Icon(
                                  Icons.copy,
                                  // Change this to the appropriate icon
                                  color: Colors.white,
                                ),
                              ],
                            )
                          ),
                          SizedBox(height: 8), // Spacing between text
                          Align(
                            alignment: Alignment.center,
                            child: Text(
                              'Kode Nasabah',
                              style: TextStyle(
                                fontSize: 24,
                                fontWeight: FontWeight.w600,
                                color: Colors.white,
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
                            'Transaksi',
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
                  SizedBox(height: 0),
                  Center(
                  child :Padding(
                    padding: const EdgeInsets.all(18.0),
                     // Lebar maksimum untuk Wrap
                      child: Wrap(
                      alignment: WrapAlignment.center,
                      spacing: 6.5,
                      // Spacing antara setiap bulan
                      children: [
                        Text('Januari', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black38,
                        )),
                        Text('|', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black,
                        )),
                        Text('Februari', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black38,
                        )),
                        Text('|', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black,
                        )),
                        Text('Maret', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black38,
                        )),
                        Text('|', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black,
                        ),
                        ),
                        Text('April', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black,
                        )),
                        Text('|', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black,
                        ),
                        ),
                        Text('Mei', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black38,
                        )),
                        Text('|', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black,
                        ),
                        ),
                        Text('Juni', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black38,
                        )),
                        Text('|', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black,
                        ),
                        ),
                        Text('Juli', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black38,
                        )),
                        Text('|', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black,
                        ),
                        ),
                        Text('Agustus', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black38,
                        )),
                        Text('|', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black,
                        ),
                        ),
                        Text('September', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black38,
                        )),
                        Text('|', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black,
                        ),
                        ),
                        Text('Oktober', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black38,
                        )),
                        Text('|', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black,
                        ),
                        ),
                        Text('November', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black38,
                        )),
                        Text('|', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black,
                        ),
                        ),
                        Text('Desember', style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.normal,
                          color: Colors.black38,
                        )),

                      ],
                    ),
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