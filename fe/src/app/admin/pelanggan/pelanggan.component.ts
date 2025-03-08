import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { SidebarComponent } from '../left-sidebar/left-sidebar.component';

@Component({
  selector: 'admin-app-pelanggan',
  imports: [CommonModule,SidebarComponent],
  templateUrl: './pelanggan.component.html',
  styleUrl: './pelanggan.component.css'
})
export class AdminPelangganComponent implements OnInit {
  pelangganList: any[] = [];
  apiUrl = 'http://localhost/mahiahijab/api/admin/pelanggan/pelanggan.php';

  constructor(private http: HttpClient) { }

  ngOnInit(): void {
    this.getPelanggan();
  }

  getPelanggan(): void {
    this.http.get<any>(this.apiUrl).subscribe(
      (response) => {
        // console.log(response.data);
        this.pelangganList = response.data;
      },
      (error) => {
        console.error('Error fetching data:', error);
      }
    );
  }

  deletePelanggan(id: string): void {
    if (confirm('Apakah Anda yakin ingin menghapus data pelanggan ini?')) {
      const deleteUrl = `${this.apiUrl}?id=${id}`; // Gunakan metode DELETE dengan ID sebagai URL param
      // console.log('Menghapus pelanggan dengan ID:', id); // Debugging
      // console.log('Request URL:', deleteUrl); // Debugging

      this.http.delete<any>(deleteUrl).subscribe(
        (response) => {
          console.log('Response dari API Hapus:', response); // Debugging
          if (response.status === 'success') {
            alert('Data Pelanggan sudah dihapus');
            this.getPelanggan(); // Refresh data setelah penghapusan
          } else {
            alert('Gagal menghapus data pelanggan.');
          }
        },
        (error) => {
          console.error('Error deleting pelanggan:', error);
        }
      );
    }
  }
}
