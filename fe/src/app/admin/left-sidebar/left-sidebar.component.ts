import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { LogoutService } from '../logout/logout.service';


@Component({
    selector: 'app-sidebar',
    standalone: true,
    
    templateUrl: './left-sidebar.component.html',
    styleUrls: ['./left-sidebar.component.css']
})
export class SidebarComponent {
    constructor(private logoutService: LogoutService, private router: Router) {}

    onLogout(): void {
        if (confirm('Yakin ingin logout?')) {
            this.logoutService.logout();
        }
    }

    onPelanggan(): void {
        this.router.navigate(['/admin/pelanggan']).then(() => {
            console.log('Navigasi ke halaman pelanggan.');
        });
    }

    onProduct(): void {
      this.router.navigate(['/admin/product']).then(() => {
          console.log('Navigasi ke halaman Product.');
      });
  }

    onDashboard(): void {
      this.router.navigate(['/admin/dashboard']).then(() => {
          console.log('Navigasi ke halaman dashboard.');
      });
  }
}
