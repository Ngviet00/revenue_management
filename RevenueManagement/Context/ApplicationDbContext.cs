using Microsoft.AspNetCore.Identity;
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

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<Role>().HasData(
                new Role { Id = 1, Name = "SuperAdmin" },
                new Role { Id = 2, Name = "Admin" },
                new Role { Id = 3, Name = "Staff" }
            );

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
        }
    }
}
