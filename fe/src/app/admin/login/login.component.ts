import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class AdminLoginComponent {
  u: string = ''; // Username
  p: string = ''; // Password
  apiUrl = 'http://localhost/mahiahijab/api/admin/auth/login.php';

  constructor(private http: HttpClient, public router: Router) { }

  onLogin() {
    if (!this.u || !this.p) {
      Swal.fire('Error', 'Harap isi semua kolom!', 'error');
      return;
    }

    // Menggunakan metode GET dengan parameter di URL
    const url = `${this.apiUrl}?username=${this.u}&password=${this.p}`;

    this.http.get<any>(url).subscribe(
      (response) => {
        alert(response);
        if (response.success) {
          localStorage.setItem('user', JSON.stringify(response.data));
          Swal.fire('Success', 'Login Berhasil', 'success').then(() => {
            this.router.navigate(['/dashboard']);
          });
        } else {
          Swal.fire('Error', 'Username atau Password salah!', 'error');
          alert('Username atau Password salah!');
        }
      },
      (error) => {
        Swal.fire('Error', 'Terjadi kesalahan server!', 'error');
        alert('Terjadi kesalahan server!');
      }
    );
  }
}
