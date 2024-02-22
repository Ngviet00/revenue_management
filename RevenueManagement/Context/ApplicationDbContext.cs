using Microsoft.EntityFrameworkCore;
using RevenueManagement.Models.Entities;

namespace RevenueManagement.Context
{
    public class ApplicationDbContext : DbContext
    {
        public ApplicationDbContext(DbContextOptions<ApplicationDbContext> options) : base(options)
        {
        }

        public DbSet<Role> Roles { get; set; }
        public DbSet<User> Users { get; set; }
        public DbSet<Company> Companies { get; set; }
        public DbSet<Order> Orders { get; set; }
        public DbSet<UserCompany> UserCompanies { get; set; }
        public DbSet<UserCompanyOrder> UserCompanyOrders { get; set; }
        public DbSet<Notification> Notifications { get; set; }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            //seed data table roles
            modelBuilder.Entity<Role>().HasData(
                new Role { Id = 1, Name = "SuperAdmin" },
                new Role { Id = 2, Name = "Admin" },
                new Role { Id = 3, Name = "Staff" }
            );

            //seed superadmin
            modelBuilder.Entity<User>().HasData(
                new User
                {
                    Id = 1,
                    Name = "superadmin",
                    Username = "superadmin",
                    Password = Utils.Security.MD5Hash("123456"),
                    RoleId = 1
                }
            );

            //set relationship notification with user
            modelBuilder.Entity<Notification>()
                .HasOne<User>(s => s.User)
                .WithMany(g => g.Notifications)
                .HasForeignKey(s => s.ReceiveUserId);

            //set relationship user_company
            modelBuilder.Entity<UserCompany>().HasKey(ur => new { ur.UserId, ur.CompanyId });
            
            modelBuilder.Entity<UserCompany>()
                .HasOne(ur => ur.User)
                .WithMany(u => u.UserCompanies)
                .HasForeignKey(ur => ur.UserId)
                .OnDelete(DeleteBehavior.Cascade);

            modelBuilder.Entity<UserCompany>()
                .HasOne(ur => ur.Company)
                .WithMany(r => r.UserCompanies)
                .HasForeignKey(ur => ur.CompanyId)
                .OnDelete(DeleteBehavior.Cascade);

            //set relationship user_company_order
            modelBuilder.Entity<UserCompanyOrder>()
                .HasOne(ur => ur.User)
                .WithMany(u => u.UserCompanyOrders)
                .HasForeignKey(ur => ur.UserId)
                .OnDelete(DeleteBehavior.Cascade);

            modelBuilder.Entity<UserCompanyOrder>()
                .HasOne(ur => ur.Company)
                .WithMany(r => r.UserCompanyOrders)
                .HasForeignKey(ur => ur.CompanyId)
                .OnDelete(DeleteBehavior.Cascade);

            modelBuilder.Entity<UserCompanyOrder>()
                .HasOne(ur => ur.Order)
                .WithMany(r => r.UserCompanyOrders)
                .HasForeignKey(ur => ur.OrderId)
                .OnDelete(DeleteBehavior.Cascade);
        }
    }
}
