import { Component } from '@angular/core';
import { LeftSidebarComponent } from '../left-sidebar/left-sidebar.component';
import { TopbarComponent } from '../topbar/topbar.component';

@Component({
  selector: 'admin-app-header',
  imports: [LeftSidebarComponent, TopbarComponent],
  templateUrl: './header.component.html',
  styleUrl: './header.component.css'
})
export class HeaderComponent {

}
