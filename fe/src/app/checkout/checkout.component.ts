import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { RajaOngkirService } from '../service/rajaongkir.service';
import { OrderService } from './order.service';
import { CommonModule } from '@angular/common';
import { NavbarComponent } from '../navbar/navbar.component';
import { FooterComponent } from '../footer/footer.component';
import { ProductService } from '../service/product.service';

@Component({
  selector: 'app-checkout',
  templateUrl: './checkout.component.html',
  styleUrls: ['./checkout.component.css'],
  imports: [CommonModule, NavbarComponent, FooterComponent, ReactiveFormsModule]
})
export class CheckoutComponent implements OnInit {
  checkoutForm: FormGroup;
  provinces: any[] = [];
  cities: any[] = [];
  cartItems: any[] = [];
  totalHarga: number = 0;
  subtotal: number = 0;
  ongkir: number = 0;
  id_pelanggan: number = 0;


  constructor(
    private fb: FormBuilder,
    private rajaOngkirService: RajaOngkirService,
    private orderService: OrderService,
    private productService: ProductService
  ) {
    this.checkoutForm = this.fb.group({
      nama: ['', Validators.required],
      no_telp: ['', [Validators.required, Validators.pattern('^[0-9]+$')]],
      province_destination: ['', Validators.required],
      city_destination: ['', Validators.required],
      kodePos: ['', Validators.required],
      alamat: ['', Validators.required],
      catatan: [''],
      ongkir: [0, Validators.required],
      subtotal: [0, Validators.required]
    });
  }

  ngOnInit(): void {
    this.loadProvinces();
    this.loadCart();
  }

  loadProvinces() {
    this.rajaOngkirService.getProvinces().subscribe(response => {
      this.provinces = response.rajaongkir.results;
    });
  }

  // Load daftar kota berdasarkan provinsi yang dipilih
  loadCities() {
    const provinceId = this.checkoutForm.value.province_destination;
    if (!provinceId) return;

    this.rajaOngkirService.getCities(provinceId).subscribe(response => {
      this.cities = response.rajaongkir.results;
    });
  }

  // Set kode pos berdasarkan kota yang dipilih
  setPostalCodeAndOngkir(cityId: string) {
    const selectedCity = this.cities.find(city => city.city_id === cityId);
    console.log(selectedCity);
    if (selectedCity) {
      this.checkoutForm.patchValue({ kodePos: selectedCity.postal_code });
      this.calculateOngkir(cityId); // Hitung ongkir setelah memilih kota
    }
  }
  getProvinces() {
    this.rajaOngkirService.getProvinces().subscribe(data => {
      this.provinces = data.rajaongkir.results;
      // console.log();
    });
  }

  getCities(provinceId: string) {
    this.rajaOngkirService.getCities(provinceId).subscribe(data => {
      this.cities = data.rajaongkir.results;
    });
  }

  calculateSubtotal() {
    this.subtotal = this.cartItems.reduce((total, item) => total + (item.harga * item.jumlah), 0);
  }

  calculateOngkir(destinationCityId: string) {
    const origin = '171'; // Kota asal (kode kota pengirim)
    const weight = 2; // Berat dalam gram (1 produk = 200 gram)
    const courier = 'jne';

    if (!destinationCityId || weight <= 0) return;

    this.rajaOngkirService.calculateOngkir(origin, destinationCityId, weight, courier).subscribe(response => {
      console.log(response.rajaongkir);
      if (response.rajaongkir && response.rajaongkir.results.length > 0) {
        const ongkirValue = response.rajaongkir.results[0].costs[0].cost[0].value;
        this.ongkir = ongkirValue;
        this.totalHarga = this.subtotal + this.ongkir; // Update total harga
      }


    });
  }

  loadCart() {
    const storedCart = localStorage.getItem('cart');
    if (!storedCart) {
      this.cartItems = [];
      this.calculateSubtotal();
      return;
    }

    const cartData = JSON.parse(storedCart); // Format { 'id_produk': jumlah }
    this.cartItems = [];
    this.subtotal = 0;

    Object.keys(cartData).forEach(id_produk => {
      this.productService.getProductById(id_produk).subscribe(response => {
        if (response.status === 'success') {
          const product = response.data;
          const quantity = cartData[id_produk];
          const itemSubtotal = parseFloat(product.harga) * quantity;

          this.cartItems.push({
            id_produk: product.id_produk,
            nm_produk: product.nm_produk,
            gambar: product.gambar,
            harga: parseFloat(product.harga),
            quantity: quantity,
            subtotal: itemSubtotal
          });


          this.subtotal += itemSubtotal; // Hitung subtotal langsung di sini
          this.totalHarga = this.subtotal + this.ongkir; // Update total harga
        }
      });
    });
  }

  calculateTotal() {
    this.totalHarga = this.cartItems.reduce((sum, item) => sum + item.harga * item.jumlah, 0);
  }

  placeOrder() {
    if (this.checkoutForm.invalid) {
      alert('Harap isi semua data dengan benar.');
      return;
    }

    const userData = localStorage.getItem('user');
    if (userData) {
      const user = JSON.parse(userData);
      this.id_pelanggan = user.id_pelanggan;
    }

    const orderData = {
      id_pelanggan: this.id_pelanggan, // ID pelanggan statis, ganti dengan dynamic jika ada sistem login
      no_telp: this.checkoutForm.value.no_telp,
      province_destination: this.checkoutForm.value.province_destination,
      city_destination: this.checkoutForm.value.city_destination,
      kodePos: this.checkoutForm.value.kodePos,
      alamat: this.checkoutForm.value.alamat,
      catatan: this.checkoutForm.value.catatan,
      ongkir: this.ongkir,
      subtotal: this.totalHarga,
      id_produk: this.cartItems.map(item => item.id_produk),
      jumlah: this.cartItems.map(item => item.jumlah)
    };

    console.log(orderData);

    // this.orderService.placeOrder(orderData).subscribe(response => {
    //   alert('Pesanan berhasil dibuat!');
    //   localStorage.removeItem('cart'); // Hapus keranjang setelah checkout
    // }, error => {
    //   // alert('Terjadi kesalahan saat melakukan pemesanan.');
    //   alert(error.status);
    // });
  }
}
