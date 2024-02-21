using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace RevenueManagement.Models.Entities
{
    [Table("orders")]
    public class Order
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        [Column("id", TypeName = "bigint")]
        public long Id { get; set; }

        [Column("title"), MaxLength(255)]
        public string? Title { get; set; }

        [Column("type")]
        public int Type { get; set; }

        [Column("seller"), MaxLength(255)]
        public string? Seller { get; set; }

        [Column("weight")]
        public decimal? Weight { get; set; }

        [Column("price")]
        public decimal? Price { get; set; }

        [Column("total_money")]
        public decimal? TotalMoney { get; set; }

        [Column("created_at")]
        public DateTime? CreatedAt { get; set; }

        [Column("updated_at")]
        public DateTime? UpdatedAt { get; set; }

        [Column("deleted_at")]
        public DateTime? DeletedAt { get; set; }
    }
}
