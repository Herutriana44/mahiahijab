import { ComponentFixture, TestBed } from '@angular/core/testing';

import { KonfirmasiBarangComponent } from './konfirmasi-barang.component';

describe('KonfirmasiBarangComponent', () => {
  let component: KonfirmasiBarangComponent;
  let fixture: ComponentFixture<KonfirmasiBarangComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [KonfirmasiBarangComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(KonfirmasiBarangComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
