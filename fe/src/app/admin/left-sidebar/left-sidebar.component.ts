import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { CommonModule } from '@angular/common'; // Tambahkan CommonModule
import { LogoutService } from '../logout/logout.service';

@Component({
    selector: 'app-sidebar',
    standalone: true,
    templateUrl: './left-sidebar.component.html',
    styleUrls: ['./left-sidebar.component.css'],
    imports: [CommonModule], // Daftarkan modul CommonModule
    providers: [LogoutService], // Daftarkan LogoutService di sini
})
export class SidebarComponent {
    activePage: string = '';

    constructor(public router: Router, private logoutService: LogoutService) {}

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
}
