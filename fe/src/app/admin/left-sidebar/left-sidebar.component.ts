import { AfterViewInit, Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CommonModule } from '@angular/common'; // Tambahkan CommonModule
import { LogoutService } from '../logout/logout.service';
import { HttpClient } from '@angular/common/http';

@Component({
    selector: 'app-sidebar',
    standalone: true,
    templateUrl: './left-sidebar.component.html',
    styleUrls: ['./left-sidebar.component.css'],
    imports: [CommonModule], // Daftarkan modul CommonModule
    providers: [LogoutService], // Daftarkan LogoutService di sini
})
export class SidebarComponent implements OnInit, AfterViewInit {
    activePage: string = '';

    constructor(public router: Router, private logoutService: LogoutService, private http: HttpClient) { }
    ngAfterViewInit(): void {
        throw new Error('Method not implemented.');
    }

    ngOnInit(): void {
        this.checkLogin();
    }

    onNavigate(route: string): void {
        this.activePage = route.split('/').pop() || '';
        this.router.navigate([route]).then(() => {
            console.log(`Navigasi ke halaman ${this.activePage}`);
            window.location.reload(); // Refresh halaman
        });
    }

    onLogout(): void {
        if (confirm('Yakin ingin logout?')) {
            this.logoutService.logout();
        }
    }

    checkLogin(): void {
        this.http.get<any>('http://localhost/mahiahijab/api/admin/auth/check.php', { withCredentials: true })
            .subscribe({
                next: (response) => {
                    if (response.status != 'success') {
                        this.redirectToLogin();
                    }
                },
                error: (err) => {
                    console.error('Gagal memeriksa sesi', err);
                    this.redirectToLogin();
                }
            });
    }

    redirectToLogin(): void {
        alert('Silakan login terlebih dahulu!');
        this.router.navigate(['/admin/login']);
    }
}
