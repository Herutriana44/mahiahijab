import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'admin-app-edit-product',
  templateUrl: './edit-product.component.html',
  styleUrls: ['./edit-product.component.css'],
  imports: [CommonModule, FormsModule]
})
export class AdminEditProductComponent implements OnInit {
  productId: string = '';
  productData: any = {
    id_kategori: '',
    nama: '',
    berat: '',
    harga: '',
    stok: '',
    deskripsi: '',
    img: { name: '', data: '' }
  };
  apiUrl = 'http://localhost/mahiahijab/api/admin/product/Product.php';
  previewImage: string | ArrayBuffer | null = '';

  constructor(
    private route: ActivatedRoute,
    private http: HttpClient,
    private router: Router
  ) { }

  ngOnInit() {
    this.productId = this.route.snapshot.paramMap.get('id') || '';
    this.getProduct();
  }

  // Mengambil data produk berdasarkan ID
  getProduct() {
    this.http.get(`${this.apiUrl}?id=${this.productId}`).subscribe(
      (response: any) => {
        if (response) {
          console.log('Product Data:', response);
          this.productData = response;
          if (this.productData.gambar) {
            this.previewImage = `../../../assets/admin/assets/images/foto_produk/${this.productData.gambar}`;
          }
        } else {
          alert('Produk tidak ditemukan!');
          this.router.navigate(['/products']);
        }
      },
      (error) => {
        console.error('Error fetching product:', error);
        alert('Gagal mengambil data produk.');
      }
    );
  }

  // Mengubah file gambar menjadi base64
  onFileSelected(event: any) {
    const file = event.target.files[0];

    if (file) {
      const reader = new FileReader();
      reader.onload = (e: any) => {
        this.productData.img = {
          name: file.name,
          data: e.target.result.split(',')[1] // Ambil base64 tanpa prefix data:image/*
        };
        this.previewImage = e.target.result; // Tampilkan preview gambar
      };
      reader.readAsDataURL(file);
    }
  }

  // Simpan perubahan produk
  updateProduct() {
    const headers = new HttpHeaders({ 'Content-Type': 'application/json' });

    this.http.put(`${this.apiUrl}?id=${this.productId}`, JSON.stringify(this.productData), { headers })
      .subscribe(
        (response: any) => {
          console.log('Update Response:', response);
          if (response.status === 'success') {
            alert('Produk berhasil diperbarui!');
            this.router.navigate(['/products']);
          } else {
            alert('Gagal memperbarui produk! Periksa kembali data yang dikirim.');
          }
        },
        (error) => {
          console.error('Error updating product:', error);
          alert(JSON.stringify(error));
        }
      );
  }
}
