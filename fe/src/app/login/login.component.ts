import { Component } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  u: string = '';
  p: string = '';

  constructor(private http: HttpClient, private router: Router) {}

  onLogin() {
    const body = new URLSearchParams();
    body.set('u', this.u);
    body.set('p', this.p);
    
    const headers = new HttpHeaders({ 'Content-Type': 'application/x-www-form-urlencoded' });
    
    this.http.post<any>('http://localhost/mahiahijab/api/auth/login.php', body.toString(), { headers })
      .subscribe(
        response => {
          if (response.status === 'success') {
            alert('Login Berhasil');
            localStorage.setItem('user', JSON.stringify(response.pelanggan));
            localStorage.setItem('isLogin', 'true');
            this.router.navigate(['/']);
          } else {
            alert('Login Gagal! Username atau Password salah');
          }
        },
        error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan, coba lagi nanti.');
        }
      );
  }
}
