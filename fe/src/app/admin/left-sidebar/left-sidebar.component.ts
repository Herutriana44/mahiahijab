import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
    selector: 'app-sidebar',
    standalone: true,
    templateUrl: './left-sidebar.component.html',
    styleUrls: ['./left-sidebar.component.css']
})
export class SidebarComponent {
    activePage: string = '';

    constructor(public router: Router) { }

    onNavigate(route: string): void {
        this.activePage = route.split('/').pop() || '';
        this.router.navigate([route]).then(() => {
            console.log(`Navigasi ke halaman ${this.activePage}`);
            window.location.reload(); // Refresh halaman setelah navigasi
        });
    }

    onLogout(): void {
        if (confirm('Yakin ingin logout?')) {
            console.log('User logged out');
        }
    }
}
