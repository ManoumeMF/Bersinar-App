import 'package:matchingfundbanksampah/components/bottom_navigation.dart';
import 'package:flutter/material.dart';

class TrashPage extends StatefulWidget {
  @override
  _TrashPageState createState() => _TrashPageState();
}

class _TrashPageState extends State<TrashPage> {
  String? tipeSampah, nasabah;
  int _selectedIndex = 3;

  void _onTabTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          title: const Text('Timbang Sampah', style:
          TextStyle(
              fontSize: 17,
              fontWeight: FontWeight.bold,
              color: Colors.white
          ),
          ),
          leading: GestureDetector(
            child: const Icon(Icons.arrow_back_ios, color: Colors.white,),
            onTap: () {},
          ),
          centerTitle: true,
          actions: const [
            Icon(Icons.home, color: Colors.yellow,),
            SizedBox(width: 20,)
          ],
          backgroundColor: Colors.green,
        ),
        bottomNavigationBar: BottomNavigationWidget(
          selectedIndex: _selectedIndex,
          onTabTapped: _onTabTapped,
        ),
        body: ListView(
          children: [
            Padding(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  DropdownButton<String>(
                    hint: Text('Pilih Nasabah', style:
                    TextStyle(
                      color: Colors.grey,
                    ),
                    ),
                    isExpanded: true,
                    value: nasabah,
                    items: ['Option 1', 'Option 2', 'Option 3']
                        .map((label) => DropdownMenuItem(
                      value: label,
                      child: Text(label),
                    ))
                        .toList(),
                    onChanged: (value) {
                      setState(() {
                        nasabah = value;
                      });
                    },
                  ),
                  const SizedBox(height: 16),
                  Row(
                    children: [
                      const Text("Timbang", style:
                      TextStyle(
                          fontSize: 17,
                          color: Colors.black,
                          fontWeight: FontWeight.w400
                      ),
                      ),
                      Expanded(child: Container(),),
                      ElevatedButton(
                        onPressed: () {},
                        style: ElevatedButton.styleFrom(
                            primary: Colors.blue,
                            padding: const EdgeInsets.all(10),
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(5),
                            ),
                            shadowColor: Colors.black
                        ),
                        child: const Text('Tambah', style:
                        TextStyle(
                          color: Colors.white,
                          fontSize: 17,
                        ),
                        ),
                      ),
                    ],
                  ),
                  entrySampah(),
                  entrySampah(),
                  entrySampah(),
                  const SizedBox(height: 20,),
                  ElevatedButton(
                    onPressed: () {},
                    style: ElevatedButton.styleFrom(
                        primary: Colors.green,
                        padding: const EdgeInsets.only(top: 10, bottom: 10),
                        fixedSize: Size(MediaQuery.of(context).size.width, 30),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(0),
                        ),
                        shadowColor: Colors.black
                    ),
                    child: const Text('Simpan', style:
                    TextStyle(
                      color: Colors.white,
                      fontSize: 15,
                    ),
                    ),
                  )
                ],
              ),
            ),
          ],
        )
    );
  }

  Widget entrySampah() {
    TextEditingController _controller = TextEditingController();

    return Column(
      children: [
        const SizedBox(height: 16),
        Row(
          children: [
            Expanded(
              child: DropdownButton<String>(
                hint: Text('Pilih Jenis Sampah'),
                isExpanded: true,
                value: tipeSampah,
                items: ['Option 1', 'Option 2', 'Option 3']
                    .map((label) => DropdownMenuItem(
                  value: label,
                  child: Text(label),
                ))
                    .toList(),
                onChanged: (value) {
                  setState(() {
                    tipeSampah = value;
                  });
                },
              ),
            ),
            const SizedBox(width: 16),
            Expanded(
              child: TextFormField(
                controller: _controller,
                decoration: InputDecoration(
                  labelText: 'Masukkan Berat',
                  suffixIcon: IconButton(
                    onPressed: () {
                      _controller.clear();
                    },
                    icon: const Icon(Icons.close_outlined),
                    color: Colors.red,
                  ),
                ),
              ),
            ),
          ],
        ),
      ],
    );
  }
}