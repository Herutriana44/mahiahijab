import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'admin-app-left-sidebar',
  imports: [CommonModule],
  templateUrl: './left-sidebar.component.html',
  styleUrl: './left-sidebar.component.css'
})
export class LeftSidebarComponent {
  activeMenu: string | null = null; // ✅ Menyimpan menu aktif

  constructor(public router: Router) { } // ✅ Inject Router

  toggleMenu(menu: string) {
    this.activeMenu = this.activeMenu === menu ? null : menu;
  }

  navigateTo(route: string) {
    this.router.navigate([route]); // ✅ Gunakan Router untuk navigasi
  }
}
