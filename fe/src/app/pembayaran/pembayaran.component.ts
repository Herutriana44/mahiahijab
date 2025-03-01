import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { NavbarComponent } from '../navbar/navbar.component';
import { FooterComponent } from '../footer/footer.component';


@Component({
  selector: 'app-pembayaran',
  imports: [CommonModule, NavbarComponent, FooterComponent],
  templateUrl: './pembayaran.component.html',
  styleUrl: './pembayaran.component.css'
})
export class PembayaranComponent {
  totalOrder: number = 0;
  orderId: string | null = '';

  constructor(private route: ActivatedRoute, private http: HttpClient) { }

  ngOnInit(): void {
    // Ambil ID dari URL
    this.orderId = this.route.snapshot.paramMap.get('id');

    if (this.orderId) {
      this.getTotalOrder(this.orderId);
    }
  }

  getTotalOrder(id: string): void {
    const apiUrl = `http://localhost/mahiahijab/api/order/totalOrder.php?id=${id}`;

    this.http.get<any>(apiUrl).subscribe(response => {
      if (response.status === 'success' && response.data) {
        this.totalOrder = response.data.total_order;
      }
    }, error => {
      console.error('Error fetching total order:', error);
    });
  }
}
