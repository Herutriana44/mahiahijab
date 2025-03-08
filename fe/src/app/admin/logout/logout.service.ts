import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';

@Injectable({
    providedIn: 'root',
})
export class LogoutService {
    constructor(private http: HttpClient, private router: Router) {}

    logout(): void {
        this.http.get('http://localhost/mahiahijab/api/admin/auth/logout.php', { withCredentials: true })
            .subscribe(() => {
                // Hapus semua data di localStorage & sessionStorage setelah server logout sukses
                localStorage.clear();
                sessionStorage.clear();

                // Redirect ke halaman login
                this.router.navigate(['/admin/login']).then(() => {
                    console.log('Logout berhasil, redirect ke halaman login.');
                });
            }, error => {
                alert('Gagal logout dari server!');
                console.error('Logout error:', error);

                // Tetap bersihkan localStorage walau server error (defensive)
                localStorage.clear();
                sessionStorage.clear();

                this.router.navigate(['/admin/login']);
            });
    }
}
