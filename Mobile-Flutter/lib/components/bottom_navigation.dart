import 'package:flutter/material.dart';

class BottomNavigationWidget extends StatelessWidget {
  final int selectedIndex;
  final Function(int) onTabTapped;

  BottomNavigationWidget({
    required this.selectedIndex,
    required this.onTabTapped,
  });

  @override
  Widget build(BuildContext context) {
    return BottomNavigationBar(
      currentIndex: selectedIndex,
      onTap: onTabTapped,
      type: BottomNavigationBarType.fixed,
      items: [
        BottomNavigationBarItem(
          icon: Padding(
            padding: EdgeInsets.only(bottom: 4),
            child: Icon(Icons.home, size: 24, color: Colors.black),
          ),
          label: 'Beranda',
        ),
        BottomNavigationBarItem(
          icon: Padding(
            padding: EdgeInsets.only(bottom: 4),
            child: Icon(Icons.history, size: 24, color: Colors.black),
          ),
          label: 'Riwayat',
        ),
        BottomNavigationBarItem(
          icon: Padding(
            padding: EdgeInsets.only(bottom: 4),
            child: Icon(Icons.date_range, size: 24, color: Colors.black),
          ),
          label: 'Jadwal',
        ),
        BottomNavigationBarItem(
          icon: Padding(
            padding: EdgeInsets.only(bottom: 4),
            child: Icon(Icons.settings, size: 24, color: Colors.black),
          ),
          label: 'Penukaran',
        ),
        BottomNavigationBarItem(
          icon: Padding(
            padding: EdgeInsets.only(bottom: 4),
            child: Icon(Icons.exit_to_app, size: 24, color: Colors.black),
          ),
          label: 'Keluar',
        ),
      ],
      selectedItemColor: Colors.black,
      unselectedItemColor: Colors.black,
      selectedLabelStyle: TextStyle(color: Colors.black),
      unselectedLabelStyle: TextStyle(color: Colors.black),
    );
  }
}