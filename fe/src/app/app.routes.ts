import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CommonModule } from '@angular/common';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule, FormBuilder, FormGroup, FormControl } from '@angular/forms';

import { NavbarComponent } from './navbar/navbar.component';
import { FooterComponent } from './footer/footer.component';
import { IndexComponent } from './index/index.component';

import { LoginComponent } from './login/login.component';

import { GalleryComponent } from './gallery/gallery.component';
import { NotaOrderComponent } from './nota-order/nota-order.component';
import { BlogComponent } from './blog/blog.component';
import { SignupComponent } from './signup/signup.component';
import { ShopComponent } from './shop/shop.component';
import { DetailProdukComponent } from './detail-produk/detail-produk.component';
import { PembayaranComponent } from './pembayaran/pembayaran.component';
import { KonfirmasiPembayaranComponent } from './konfirmasi-pembayaran/konfirmasi-pembayaran.component';
import { OrderanComponent } from './orderan/orderan.component';
import { CheckoutComponent } from './checkout/checkout.component';
import { CartComponent } from './cart/cart.component';
import { DetailBlogComponent } from './detail-blog/detail-blog.component';
import { LupaPasswordComponent } from './lupa-password/lupa-password.component';
import { RincianProdukComponent } from './rincian-produk/rincian-produk.component';


import { AdminLoginComponent } from './admin/login/login.component';
import { AdminPelangganComponent } from './admin/pelanggan/pelanggan.component';
import { AdminProdukComponent } from './admin/produk/produk.component';
import { AdminEditProductComponent } from './admin/edit-product/edit-product.component';
import { AdminAddProductComponent } from './admin/add-product/add-product.component';
import { DashboardComponent } from './admin/dashboard/dashboard.component'
import { AdminKategoriPosComponent } from './admin/kategori-pos/kategori-pos.component';
import { AdminTambahKategoriComponent } from './admin/tambah-kategori/tambah-kategori.component';


export const routes: Routes = [
    { path: '', component: IndexComponent },

    { path: 'login', component: LoginComponent },
    { path: 'lupa-password', component: LupaPasswordComponent },

    { path: 'gallery', component: GalleryComponent },
    { path: 'blog', component: BlogComponent },
    { path: 'signup', component: SignupComponent },
    { path: 'index', component: IndexComponent },
    { path: 'product/:id', component: DetailProdukComponent },
    { path: 'nota-order/:id', component: NotaOrderComponent },
    { path: 'payment/:id', component: PembayaranComponent },
    { path: 'konfirmasi-pembayaran/:id', component: KonfirmasiPembayaranComponent },
    { path: 'orderan', component: OrderanComponent },
    { path: 'checkout', component: CheckoutComponent },
    { path: 'cart', component: CartComponent },
    { path: 'blog/:id', component: DetailBlogComponent },
    { path: 'rincian-produk/:id', component: RincianProdukComponent },
    { path: 'pembayaran', component: RincianProdukComponent },

    { path: 'admin/login', component: AdminLoginComponent },
    { path: 'admin/pelanggan', component: AdminPelangganComponent },
    { path: 'admin/product', component: AdminProdukComponent },
    { path: 'admin/edit-product/:id', component: AdminEditProductComponent },
    { path: 'admin/add-product', component: AdminAddProductComponent },
    { path: 'admin/dashboard', component: DashboardComponent },
    { path: 'admin/category', component: AdminTambahKategoriComponent },
    { path: 'admin/kategori-pos', component: AdminKategoriPosComponent }
];

@NgModule({
    imports: [RouterModule.forRoot(routes), CommonModule, BrowserModule],
    exports: [RouterModule]
})
export class AppRoutingModule { }