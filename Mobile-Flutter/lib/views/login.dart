import 'package:flutter/gestures.dart';
import '../main.dart';
import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
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
      // appBar: AppBar(
      //   backgroundColor: Colors.white,
      //   foregroundColor: Colors.grey,
      //   elevation: 4,
      //   leading: Padding(
      //     padding: EdgeInsets.all(4),
      //     child: Image.asset('assets/images/bersinarlogonew.png'),
      //   ),
      // ),
      // endDrawer: Drawer(
      //   child: SafeArea(
      //     child: Column(
      //       children: <Widget>[
      //         MenuTile(title: 'Academy'),
      //         MenuTile(title: 'Challenge'),
      //         MenuTile(title: 'Event'),
      //         MenuTile(title: 'Job'),
      //         MenuTile(title: 'Developer'),
      //       ],
      //     ),
      //   ),
      // ),
      body: SingleChildScrollView(
        child: Padding(
          padding: EdgeInsets.symmetric(horizontal: 16.0, vertical: 80.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: <Widget>[
              Image.asset('assets/images/bersinartextnew.png'),
              SizedBox(
                height: 50.0,
              ),
              TextField(
                keyboardType: TextInputType.name,
                decoration: InputDecoration(
                    hintText: 'Username',
                    focusedBorder: OutlineInputBorder(),
                    border: OutlineInputBorder(),
                    isDense: true),
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
                      _isHidePassword ? Icons.visibility_off : Icons.visibility,
                      color: _isHidePassword ? Colors.grey : Colors.blue,
                    ),
                  ),
                  isDense: true,
                ),
              ),
              SizedBox(
                height: 18,
              ),
              Text(
                'Lupa Password?',
                textAlign: TextAlign.right,
                style: Theme.of(context)
                    .textTheme
                    .bodyText2!
                    .copyWith(decoration: TextDecoration.underline),
              ),
              ElevatedButton(
                onPressed: () {
                  Navigator.pushNamed(context, '/home'); // Menggunakan Navigator.pushNamed
                },
                child: Text('Masuk'),
                style: OutlinedButton.styleFrom(
                  backgroundColor: Colors.green.shade800,
                ),
              ),
              SizedBox(
                height: 8,
              ),
              RichText(
                textAlign: TextAlign.center,
                text: TextSpan(
                  text: 'Belum punya akun? ',
                  style: Theme.of(context).textTheme.bodyText1,
                  children: [
                    TextSpan(
                      text: 'Daftar',
                      recognizer: TapGestureRecognizer()
                        ..onTap = () {
                          Navigator.pushNamed(context, '/register'); // Navigasi ke halaman pendaftaran
                        },
                      style: TextStyle(
                        decoration: TextDecoration.underline,
                        fontWeight: FontWeight.bold,
                        color: Colors.blue,
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

class MenuTile extends StatelessWidget {
  final String title;

  const MenuTile({
    Key? key,
    required this.title,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return ListTile(
      title: Text(
        title,
        style: Theme.of(context)
            .textTheme
            .bodyText1!
            .copyWith(fontWeight: FontWeight.bold),
      ),
    );
  }
}
