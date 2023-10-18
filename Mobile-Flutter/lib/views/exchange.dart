import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:matchingfundbanksampah/components/bottom_navigation.dart';

class ExchangePage extends StatefulWidget {
  @override
  _ExchangePageState createState() => _ExchangePageState();
}

class _ExchangePageState extends State<ExchangePage> {
  int _selectedIndex = 0;
  TextEditingController _textFieldController = TextEditingController();
  // String selectedValue; // Deklarasi variabel selectedValue sekali saja

  void _onTabTapped(int index) {
    setState(() {
      _selectedIndex = index;
      if (index == 0) {
        Navigator.pushNamed(context, '/home');
      } else if (index == 1) {
        Navigator.pushNamed(context, '/history');
      } else if (index == 2) {
        Navigator.pushNamed(context, '/schedule');
      } else if (index == 3) {
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
      appBar: PreferredSize(
        preferredSize: Size.fromHeight(56 + MediaQuery.of(context).padding.bottom),
        child: AppBar(
          backgroundColor: Colors.green,
          title: Center(
            child: Text(
              'Ajukan Penukaran Dana',
              style: TextStyle(
                color: Colors.white,
              ),
            ),
          ),
          leading: IconButton(
            icon: Icon(FontAwesomeIcons.angleLeft),
            onPressed: () {
              // Tindakan saat ikon kiri ditekan
            },
          ),
          actions: <Widget>[
            Padding(padding: EdgeInsets.only(right: 14),
              child: IconButton(
                icon: Icon(FontAwesomeIcons.home,color: Colors.orangeAccent,),
                onPressed: () {
                  // Tindakan saat ikon kanan ditekan
                },
              ),
            ),
          ],
        ),
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: EdgeInsets.symmetric(horizontal: 2.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // User icon and text

              // Center everything vertically
              Column(
                children: [
                  // Colored box with BoxDecoration
                  SizedBox(height: 10,),
                  Center(
                    child:Container(
                      width: screenWidth - 32,
                      height: 120,
                      decoration: BoxDecoration(
                        color: Colors.black12.withOpacity(0.1),
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
                                    color: Colors.black54,
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
                                        color: Colors.black54,
                                      ),
                                    ),
                                    SizedBox(width: 8), // Spacing between text and icon
                                    Icon(
                                      Icons.copy,
                                      // Change this to the appropriate icon
                                      color: Colors.black54,
                                    ),
                                  ],
                                )
                            ),
                            SizedBox(height: 8), // Spacing between text
                            Align(
                              alignment: Alignment.center,
                              child: Text(
                                'Rp.20.000,00',
                                style: TextStyle(
                                  fontSize: 24,
                                  fontWeight: FontWeight.w600,
                                  color: Colors.black54,
                                ),
                              ),
                            ),
                          ],
                        ),
                      ),
                    ),
                  ),
                ],
              ),

              SizedBox(height: 16), // Add some spacing
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 16.0),
                child: DropdownButtonFormField(
                  decoration: InputDecoration(
                    labelText: 'Pilih Kategori Rekening',
                    labelStyle: TextStyle(color: Colors.black), // Warna label
                    border: UnderlineInputBorder(
                      borderSide: BorderSide(color: Colors.black), // Warna garis bawah
                    ),
                    enabledBorder: UnderlineInputBorder(
                      borderSide: BorderSide(color: Colors.black), // Warna garis bawah saat tidak aktif
                    ),
                    focusedBorder: UnderlineInputBorder(
                      borderSide: BorderSide(color: Colors.black), // Warna garis bawah saat aktif
                    ),
                  ),
                  items: [
                    DropdownMenuItem(
                      value: 'Option 1',
                      child: Container(
                        width: 200, // Atur lebar di sini
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(30), // Atur radius cekungan di sini
                        ),
                        child: Text('Option 1'),
                      ),
                    ),
                    DropdownMenuItem(
                      value: 'Option 2',
                      child: Container(
                        width: 150, // Atur lebar di sini
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(8), // Atur radius cekungan di sini
                        ),
                        child: Text('Option 2'),
                      ),
                    ),
                    DropdownMenuItem(
                      value: 'Option 3',
                      child: Container(
                        width: 250, // Atur lebar di sini
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(8), // Atur radius cekungan di sini
                        ),
                        child: Text('Option 3'),
                      ),
                    ),
                  ],
                  onChanged: (value) {
                    setState(() {
                      // selectedValue = value;
                    });

                  },
                ),
              ),
              SizedBox(height: 16), // Add some spacing
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 16.0),
                child: DropdownButtonFormField(
                  decoration: InputDecoration(
                    labelText: 'Pilih Rekening',
                    labelStyle: TextStyle(color: Colors.black), // Warna label
                    border: UnderlineInputBorder(
                      borderSide: BorderSide(color: Colors.black), // Warna garis bawah
                    ),
                    enabledBorder: UnderlineInputBorder(
                      borderSide: BorderSide(color: Colors.black), // Warna garis bawah saat tidak aktif
                    ),
                    focusedBorder: UnderlineInputBorder(
                      borderSide: BorderSide(color: Colors.black), // Warna garis bawah saat aktif
                    ),
                  ),
                  items: [
                    DropdownMenuItem(
                      value: 'Option 1',
                      child: Container(
                        width: 200, // Atur lebar di sini
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(30), // Atur radius cekungan di sini
                        ),
                        child: Text('Option 1'),
                      ),
                    ),
                    DropdownMenuItem(
                      value: 'Option 2',
                      child: Container(
                        width: 150, // Atur lebar di sini
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(8), // Atur radius cekungan di sini
                        ),
                        child: Text('Option 2'),
                      ),
                    ),
                    DropdownMenuItem(
                      value: 'Option 3',
                      child: Container(
                        width: 250, // Atur lebar di sini
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(8), // Atur radius cekungan di sini
                        ),
                        child: Text('Option 3'),
                      ),
                    ),
                  ],
                  onChanged: (value) {
                    setState(() {
                      // selectedValue = value;
                    });

                  },
                ),
              ),
              SizedBox(height: 16), // Add some spacing
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 16.0),
                child: TextField(
                  controller: _textFieldController,
                  decoration: InputDecoration(
                    labelText: 'Nomor Rekening',
                    labelStyle: TextStyle(color: Colors.black), // Warna label
                    border: UnderlineInputBorder(
                      borderSide: BorderSide(color: Colors.black), // Warna garis bawah
                    ),
                    enabledBorder: UnderlineInputBorder(
                      borderSide: BorderSide(color: Colors.black), // Warna garis bawah saat tidak aktif
                    ),
                    focusedBorder: UnderlineInputBorder(
                      borderSide: BorderSide(color: Colors.black), // Warna garis bawah saat aktif
                    ),
                  ),
                  onChanged: (text) {
                    // Di sini Anda dapat melakukan sesuatu dengan teks yang diinputkan.
                  },
                ),
              ),
              SizedBox(height: 16), // Add some spacing
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 16.0),
                child: TextField(
                  controller: _textFieldController,
                  decoration: InputDecoration(
                    labelText: 'Masukkan Nominal',
                    labelStyle: TextStyle(color: Colors.black), // Warna label
                    border: UnderlineInputBorder(
                      borderSide: BorderSide(color: Colors.black), // Warna garis bawah
                    ),
                    enabledBorder: UnderlineInputBorder(
                      borderSide: BorderSide(color: Colors.black), // Warna garis bawah saat tidak aktif
                    ),
                    focusedBorder: UnderlineInputBorder(
                      borderSide: BorderSide(color: Colors.black), // Warna garis bawah saat aktif
                    ),
                  ),
                  onChanged: (text) {
                    // Di sini Anda dapat melakukan sesuatu dengan teks yang diinputkan.
                  },
                ),
              ),
              SizedBox(height: 16), // Add some spacing
              Center(
              child: Padding(
                padding: const EdgeInsets.symmetric(horizontal: 16.0),
                child: ElevatedButton(
                  style: ElevatedButton.styleFrom(
                    primary: Colors.green, // Mengatur warna latar belakang tombol
                  ),
                  onPressed: () {
                    // Tindakan yang ingin Anda lakukan saat tombol ditekan
                  },
                  child: Text('Ajukan'),
                ),
              ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}