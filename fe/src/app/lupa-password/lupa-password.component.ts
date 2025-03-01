import { Component } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-lupa-password',
  imports: [CommonModule],
  templateUrl: './lupa-password.component.html',
  styleUrl: './lupa-password.component.css'
})
export class LupaPasswordComponent {
  nama: string = '';
  username: string = '';
  email: string = '';
  password: string = '';
  successMessage: string = '';

  constructor(private http: HttpClient) { }

  signup(): void {
    // Data dalam format x-www-form-urlencoded
    const body = new URLSearchParams();
    body.set('nama', this.nama);
    body.set('username', this.username);
    body.set('email', this.email);
    body.set('password', this.password);

    const headers = new HttpHeaders({ 'Content-Type': 'application/x-www-form-urlencoded' });

    this.http.post('http://localhost/mahiahijab/api/auth/signup.php', body.toString(), { headers })
      .subscribe(
        response => {
          this.successMessage = 'Selamat, Anda Sudah Terdaftar!';
          setTimeout(() => {
            window.location.href = '/login';  // Redirect ke halaman login
          }, 1000);
        },
        error => {
          console.error('Signup gagal:', error);
        }
      );
  }
}
