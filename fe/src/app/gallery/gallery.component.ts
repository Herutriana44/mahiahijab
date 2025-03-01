import { Component, OnInit } from '@angular/core';
import { GalleryService } from './gallery.service';
import { NavbarComponent } from '../navbar/navbar.component';
import { FooterComponent } from '../footer/footer.component';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';


@Component({
  selector: 'app-gallery',
  templateUrl: './gallery.component.html',
  styleUrls: ['./gallery.component.css'],
  imports: [NavbarComponent, FooterComponent, CommonModule]
})
export class GalleryComponent implements OnInit {
  products: any[] = [];

  constructor(private galleryService: GalleryService) { }

  ngOnInit(): void {
    this.galleryService.getGallery().subscribe(response => {
      if (response.status === 'success') {
        this.products = response.data;
      }
    }, error => {
      console.error('Error fetching gallery data:', error);
    });
  }
}
