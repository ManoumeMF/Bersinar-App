import 'package:flutter/material.dart';
import 'package:matchingfundbanksampah/views/exchange.dart';
import 'package:matchingfundbanksampah/views/history.dart';
import 'views/login.dart'; // Import halaman login
import 'views/register.dart'; // Import halaman pendaftaran
import 'views/home.dart'; // Import halaman Beranda
import 'views/history.dart';
import 'views/schedule.dart';
import 'views/exchange.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'BerSinar',
      theme: ThemeData(
        fontFamily: 'Quicksand',
        primaryColor: Colors.white,
        visualDensity: VisualDensity.adaptivePlatformDensity,
      ),
      initialRoute: '/login',
      routes: {
        '/login': (context) => LoginPage(),
        '/register': (context) => RegisterPage(),
        '/home': (context) => HomePage(),
        '/history': (context) => HistoryPage(),
        '/schedule': (context)=> SchedulePage(),
        '/exchange': (context)=> ExchangePage()
      },
    );
  }
}