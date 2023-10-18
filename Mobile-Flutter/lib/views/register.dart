import 'package:flutter/material.dart';

class RegisterPage extends StatefulWidget {
  @override
  _RegisterPageState createState() => _RegisterPageState();
}

class _RegisterPageState extends State<RegisterPage> {
  bool _isHidePassword = true;

  void _togglePasswordVisibility() {
    setState(() {
      _isHidePassword = !_isHidePassword;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: SingleChildScrollView(
        child: Padding(
          padding: EdgeInsets.symmetric(horizontal: 16.0, vertical: 80.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: <Widget>[
              Container(
                height: 150, // Set the desired height
                width: 150,  // Set the desired width
                child: Image.asset('assets/images/bersinartextnew.png'),
              ),
              SizedBox(
                height: 20.0,
              ),
              Center(

                child: Text(
                  'Registrasi',
                  style: Theme.of(context).textTheme.headline4!.copyWith(
                      color: Colors.black, fontWeight: FontWeight.bold),
                ),
              ),
              SizedBox(
                height: 16,
              ),
              TextField(
                keyboardType: TextInputType.name,
                decoration: InputDecoration(
                  hintText: 'Nama Lengkap',
                  focusedBorder: OutlineInputBorder(),
                  border: OutlineInputBorder(),
                  isDense: true,
                ),
              ),
              SizedBox(
                height: 16,
              ),
              TextField(
                keyboardType: TextInputType.emailAddress,
                decoration: InputDecoration(
                  hintText: 'Email',
                  focusedBorder: OutlineInputBorder(),
                  border: OutlineInputBorder(),
                  isDense: true,
                ),
              ),
              SizedBox(
                height: 16,
              ),
              TextField(
                obscureText: _isHidePassword,
                keyboardType: TextInputType.visiblePassword,
                decoration: InputDecoration(
                  hintText: 'Password',
                  focusedBorder: OutlineInputBorder(),
                  border: OutlineInputBorder(),
                  suffixIcon: GestureDetector(
                    onTap: () {
                      _togglePasswordVisibility();
                    },
                    child: Icon(
                      _isHidePassword
                          ? Icons.visibility_off
                          : Icons.visibility,
                      color: _isHidePassword ? Colors.grey : Colors.blue,
                    ),
                  ),
                  isDense: true,
                ),
              ),
              SizedBox(
                height: 18,
              ),
              ElevatedButton(
                onPressed: () {
                  Navigator.pop(context);
                },
                child: Text('Daftar'),
                style: OutlinedButton.styleFrom(
                  backgroundColor: Colors.green.shade800,
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}