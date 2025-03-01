import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { NavbarComponent } from '../navbar/navbar.component';
import { FooterComponent } from '../footer/footer.component';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-konfirmasi-pembayaran',
  imports: [NavbarComponent, FooterComponent, CommonModule, ReactiveFormsModule],
  templateUrl: './konfirmasi-pembayaran.component.html',
  styleUrl: './konfirmasi-pembayaran.component.css'
})
export class KonfirmasiPembayaranComponent implements OnInit {
  paymentForm: FormGroup;
  totalOrder: number = 0;
  orderId: string | null = '';
  base64Image: string = '';

  constructor(
    private route: ActivatedRoute,
    private fb: FormBuilder,
    private http: HttpClient,
    private router: Router
  ) {
    this.paymentForm = this.fb.group({
      nama: ['', Validators.required],
      nmBank: ['', Validators.required],
      jml_transfer: ['', [Validators.required, Validators.min(1)]],
      gambar: ['', Validators.required]
    });

    // console.log(this.paymentForm);
  }

  ngOnInit(): void {
    this.orderId = this.route.snapshot.paramMap.get('id');

    if (this.orderId) {
      this.getTotalOrder(this.orderId);
    }
  }

  // Ambil total pembayaran berdasarkan ID order
  getTotalOrder(id: string): void {
    const apiUrl = `http://localhost/mahiahijab/api/order/totalOrder.php?id=${id}`;

    this.http.get<any>(apiUrl).subscribe(response => {
      if (response.status === 'success') {
        this.totalOrder = response.total_order;
      }
    }, error => {
      console.error('Error fetching total order:', error);
    });
  }

  // Konversi gambar ke format Base64
  onFileSelected(event: any): void {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => {
        this.base64Image = reader.result as string;
        this.paymentForm.patchValue({ gambar: this.base64Image });
      };
    }
  }

  // Kirim data ke API
  submitPayment(): void {
    const formData = this.paymentForm.value;

    // Format data menjadi x-www-form-urlencoded
    const body = new URLSearchParams();
    body.set('nama', formData.nama);
    body.set('nmBank', formData.nmBank);
    body.set('jml_transfer', formData.jml_transfer);
    body.set('gambar', this.base64Image);
    body.set('id', this.orderId!);

    const headers = new HttpHeaders({
      'Content-Type': 'application/x-www-form-urlencoded'
    });

    this.http.post<any>('http://localhost/mahiahijab/api/order/konfirmasiPembayaran.php', body.toString(), { headers })
      .subscribe(response => {
        // console.log(response);
        if (response.status === 'success') {
          alert('✅ Produk Segera Kami Persiapkan Untuk Dikirim');
          // this.router.navigate(['/orderan']); // Redirect ke halaman orderan
        } else {
          alert(response.message);
          // alert('❌ Gagal mengkonfirmasi pembayaran');
        }
      }, error => {
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan saat menghubungi server.');
      });
  }
}
