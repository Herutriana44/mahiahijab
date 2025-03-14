import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminAddProductComponent } from './add-product.component';

describe('AddProductComponent', () => {
  let component: AdminAddProductComponent;
  let fixture: ComponentFixture<AdminAddProductComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AdminAddProductComponent]
    })
      .compileComponents();

    fixture = TestBed.createComponent(AdminAddProductComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
