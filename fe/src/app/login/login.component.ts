import { Component } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { AppRoutingModule } from '../app.routes';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  imports: [
    FormsModule,
    HttpClientModule,
    CommonModule
  ],
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  u: string = '';
  p: string = '';

  constructor(private http: HttpClient, public router: Router) { }

  onLogin() {
    const body = new URLSearchParams();
    body.set('u', this.u);
    body.set('p', this.p);

    const headers = new HttpHeaders({ 'Content-Type': 'application/x-www-form-urlencoded' });

    this.http.post<any>('http://localhost/mahiahijab/api/auth/login.php', body.toString(), { headers })
      .subscribe(response => {
        if (response.status == 'success') {
          alert('Login Berhasil');
          // alert(response.pelanggan)
          localStorage.setItem('user', JSON.stringify(response.pelanggan));
          localStorage.setItem('isLogin', 'true');
          this.router.navigate(['/']);
        } else {
          alert('Login Gagal! Username atau Password salah');
        }
      }, error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan, coba lagi nanti.');
      });
  }
}
