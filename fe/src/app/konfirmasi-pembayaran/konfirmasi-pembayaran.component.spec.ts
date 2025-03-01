import { ComponentFixture, TestBed } from '@angular/core/testing';

import { KonfirmasiPembayaranComponent } from './konfirmasi-pembayaran.component';

describe('KonfirmasiPembayaranComponent', () => {
  let component: KonfirmasiPembayaranComponent;
  let fixture: ComponentFixture<KonfirmasiPembayaranComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [KonfirmasiPembayaranComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(KonfirmasiPembayaranComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
