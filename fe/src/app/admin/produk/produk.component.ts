import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'admin-app-produk',
  imports: [CommonModule],
  templateUrl: './produk.component.html',
  styleUrl: './produk.component.css'
})
export class AdminProdukComponent implements OnInit {
  productList: any[] = [];
  apiUrl = 'http://localhost/mahiahijab/api/admin/product/Product.php';

  constructor(public http: HttpClient) { }

  ngOnInit(): void {
    this.getProducts();
  }

  // Mengambil daftar produk dari API
  getProducts(): void {
    this.http.get<any>(this.apiUrl).subscribe(
      (response) => {
        console.log('Response dari API:', response); // Debugging
        if (response.products) {
          this.productList = response.products;
        } else {
          console.error('Data tidak ditemukan atau API gagal.');
        }
      },
      (error) => {
        console.error('Error fetching data:', error);
      }
    );
  }

  // Menghapus produk dengan metode DELETE
  deleteProduct(id: string): void {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
      const deleteUrl = `${this.apiUrl}?id=${id}`; // Kirim ID dalam parameter URL
      console.log('Menghapus produk dengan ID:', id); // Debugging

      this.http.delete<any>(deleteUrl).subscribe(
        (response) => {
          console.log('Response dari API Hapus:', response); // Debugging
          if (response.status === 'success') {
            alert('Produk berhasil dihapus');
            this.getProducts(); // Refresh daftar produk setelah penghapusan
          } else {
            alert('Gagal menghapus produk.');
          }
        },
        (error) => {
          console.error('Error deleting product:', error);
        }
      );
    }
  }
}
