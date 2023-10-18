import 'package:flutter/material.dart';
import 'package:flutter_week_view/flutter_week_view.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:matchingfundbanksampah/components/bottom_navigation.dart';

class SchedulePage extends StatefulWidget {
  @override
  _SchedulePageState createState() => _SchedulePageState();
}

class _SchedulePageState extends State<SchedulePage> {
  int _selectedIndex = 0;

  void _onTabTapped(int index) {
    setState(() {
      _selectedIndex = index;
      if (index == 0) {
        Navigator.pushNamed(context, '/home');
      } else if (index == 1) {
        Navigator.pushNamed(context, '/history');
      } else if (index == 2) {
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
    DateTime now = DateTime.now();
    DateTime date = DateTime(now.year, now.month, now.day);
    return Scaffold(
      appBar: AppBar(
        title: Text("Kamis, 5 Oktober 2023", style:
        TextStyle(
          fontSize: 17,
          fontWeight: FontWeight.bold,
          color: Colors.white,
        ),
        ),
        leading: GestureDetector(
          child: Icon(Icons.arrow_back_ios,color: Colors.white,),
          onTap: (){},
        ),
        actions: const [
          Icon(Icons.arrow_forward_ios, color: Colors.white,)
        ],
        backgroundColor: Colors.green,
        centerTitle: true,
      ),
      bottomNavigationBar: BottomNavigationWidget(
        selectedIndex: _selectedIndex,
        onTabTapped: _onTabTapped,
      ),
      body: WeekView(
        dates: [date.subtract(Duration(days: 1)), date, date.add(Duration(days: 1))],
        events: [
          FlutterWeekViewEvent(
              title: 'BS ASTER VILLAGE',
              description: 'Area Ciwestra',
              start: date.subtract(Duration(hours: 1)),
              end: date.add(Duration(hours: 1, minutes: 30)),
              backgroundColor: Colors.yellow
          ),
          FlutterWeekViewEvent(
            title: 'An event 2',
            description: 'A description 2',
            start: date.add(Duration(hours: 19)),
            end: date.add(Duration(hours: 22)),
          ),
          FlutterWeekViewEvent(
            title: 'An event 3',
            description: 'A description 3',
            start: date.add(Duration(hours: 23, minutes: 30)),
            end: date.add(Duration(hours: 25, minutes: 30)),
          ),
          FlutterWeekViewEvent(
            title: 'An event 4',
            description: 'A description 4',
            start: date.add(Duration(hours: 20)),
            end: date.add(Duration(hours: 21)),
          ),
          FlutterWeekViewEvent(
            title: 'An event 5',
            description: 'A description 5',
            start: date.add(Duration(hours: 20)),
            end: date.add(Duration(hours: 21)),
          ),
        ],
      ),
    );
  }
}